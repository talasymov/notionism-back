<?php

namespace App\Services\NotionExport;

use App\Models\BlogPost;
use App\Models\Kit;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Widget;
use App\Services\NotionExport\Blocks\Block;
use App\Services\NotionExport\Fetch\FetchService;
use Illuminate\Support\Facades\Storage;

class NotionExportService
{
    private string $pageId;

    private Template $template;

    private BlogPost $blogPost;

    private Widget $widget;

    private Kit $kit;

    public function exportTemplate(): array
    {
        ini_set('max_execution_time', 240);

        $mainPageProps = FetchService::page($this->pageId)['data']['properties'];

        $tags = collect($mainPageProps['Tags']['relation'])
            ->map(function ($tag) {
                $id = FetchService::page($tag['id'])['data']['properties']['ID']['formula']['string'];
                return Tag::where('notion_page_id', $id)->first();
            });

        $contentPageId = $mainPageProps['Content page']['relation'][0]['id'];

        $pageProps = FetchService::page($contentPageId)['data']['properties'];

        $blocksData = collect();

        $startCursor = null;

        while (true) {
            $blocks = FetchService::blocks($contentPageId, '', $startCursor);

            $blocksData = $blocksData->merge($blocks['data']['results']);

            if ($blocks['data']['has_more']) {
                $startCursor = $blocks['data']['next_cursor'];
                continue;
            }

            break;
        }

        $databases = FetchService::databases(FetchService::DATABASE_PROPERTIES, [
            'filter' => [
                'property' => 'egYR',
                'relation' => [
                    'contains' => $contentPageId
                ]
            ]
        ]);

        $databasesByTable = collect($databases['data'])->groupBy('properties.Table.rich_text.0.plain_text');

        $page = Page::getInstance();

        foreach ($blocksData as $item) {
            try {
                if ($item['type'] === 'child_database') {
                    while ($databasesByTable->isNotEmpty()) {
                        $item['child_database']['items'] = $databasesByTable->shift();
                        $page->pushBlock(Block::make($item));
                    }
                    continue;
                }
                $page->pushBlock(Block::make($item));
            } catch (\Throwable) {
            }
        }

        $this->template->fill([
            'name' => $pageProps['Name']['title'][0]['plain_text'],
            'title' => $pageProps['Meta title']['rich_text'][0]['plain_text'],
            'desc' => $pageProps['Meta description']['rich_text'][0]['plain_text'],
            'slug' => $pageProps['Slug']['rich_text'][0]['plain_text'],
            'ver' => $pageProps['Version']['rich_text'][0]['plain_text'],
            'dbs' => $pageProps['Databases']['number'],
            'props' => $pageProps['Properties']['number'],
            'pages' => $pageProps['Pages']['number'],
            'preview' => $this->uploadImage($pageProps['Preview']['files'][0], 'template'),
            'price' => $pageProps['Price']['number'],
            'link' => $pageProps['Link']['url'],
            'page_object' => $page,
            'notion_page_id' => $this->pageId,
            'html' => $page->render()->implode(''),
        ]);

        $this->template->tags()->sync($tags->pluck('id'));
        $this->template->save();

        return [
            'template' => $this->template
        ];
    }

    public function exportKit(): array
    {
        ini_set('max_execution_time', 240);

        $mainPageProps = FetchService::page($this->pageId)['data']['properties'];

        $contentPageId = $mainPageProps['Content page']['relation'][0]['id'];

        $pageProps = FetchService::page($contentPageId)['data']['properties'];

        $blocksData = collect();

        $startCursor = null;

        while (true) {
            $blocks = FetchService::blocks($contentPageId, '', $startCursor);

            $blocksData = $blocksData->merge($blocks['data']['results']);

            if ($blocks['data']['has_more']) {
                $startCursor = $blocks['data']['next_cursor'];
                continue;
            }

            break;
        }

        $page = Page::getInstance();

        foreach ($blocksData as $item) {
            try {
                $page->pushBlock(Block::make($item));
            } catch (\Throwable) {
            }
        }

        $this->kit->fill([
            'name' => $pageProps['Name']['title'][0]['plain_text'],
            'subheader' => $pageProps['Subheader']['rich_text'][0]['plain_text'],
            'title' => $pageProps['Meta title']['rich_text'][0]['plain_text'],
            'desc' => $pageProps['Meta description']['rich_text'][0]['plain_text'],
            'slug' => $pageProps['Slug']['rich_text'][0]['plain_text'],
            'preview' => $this->uploadImage($pageProps['Preview']['files'][0], 'kit'),
            'responsive_images' => $this->uploadResponsiveImages($pageProps['Responsive Images']['files'], 'kit'),
            'price' => $pageProps['Price']['number'],
            'prev_price' => $pageProps['Prev Price']['number'],
            'link' => $pageProps['Link']['url'],
            'page_object' => $page,
            'notion_page_id' => $this->pageId,
            'html' => $page->render()->implode(''),
        ]);

        $this->kit->save();

        return [
            'kit' => $this->kit
        ];
    }

    public function exportBlogPost(): array
    {
        $pageProps = FetchService::page($this->pageId)['data']['properties'];

        $blocksData = collect();

        $startCursor = null;

        while (true) {
            $blocks = FetchService::blocks($this->pageId, '', $startCursor);

            $blocksData = $blocksData->merge($blocks['data']['results']);

            if ($blocks['data']['has_more']) {
                $startCursor = $blocks['data']['next_cursor'];
                continue;
            }

            break;
        }

        $tags = collect($pageProps['🏷️ Tags']['relation'])
            ->map(function ($tag) {
                $id = FetchService::page($tag['id'])['data']['properties']['ID']['formula']['string'];
                return Tag::where('notion_page_id', $id)->first();
            });

        $page = new Page();

        foreach ($blocksData as $item) {
            try {
                $page->pushBlock(Block::make($item));
            } catch (\LogicException) {
            }
        }

        $this->blogPost->fill([
            'name' => $pageProps['Name']['title'][0]['plain_text'],
            'title' => $pageProps['Meta title']['rich_text'][0]['plain_text'],
            'desc' => $pageProps['Meta description']['rich_text'][0]['plain_text'],
            'slug' => $pageProps['Slug']['rich_text'][0]['plain_text'],
            'preview' => $this->uploadImage($pageProps['Preview']['files'][0], 'blog-post'),
            'page_object' => $page,
            'html' => $page->render()->implode(''),
            'notion_page_id' => $this->pageId
        ]);

        $this->blogPost->tags()->sync($tags->pluck('id'));
        $this->blogPost->save();

        return [
            'post' => $this->blogPost
        ];
    }

    public function exportWidget(): array
    {
        $mainPageProps = FetchService::page($this->pageId)['data']['properties'];

        $tags = collect($mainPageProps['🏷️ Tags']['relation'])
            ->map(function ($tag) {
                $id = FetchService::page($tag['id'])['data']['properties']['ID']['formula']['string'];
                return Tag::where('notion_page_id', $id)->first();
            });

        $contentPageId = $mainPageProps['Content page']['relation'][0]['id'];

        $pageProps = FetchService::page($contentPageId)['data']['properties'];

        $blocksData = collect();

        $startCursor = null;

        while (true) {
            $blocks = FetchService::blocks($contentPageId, '', $startCursor);

            $blocksData = $blocksData->merge($blocks['data']['results']);

            if ($blocks['data']['has_more']) {
                $startCursor = $blocks['data']['next_cursor'];
                continue;
            }

            break;
        }

        $page = Page::getInstance();

        foreach ($blocksData as $item) {
            try {
                $page->pushBlock(Block::make($item));
            } catch (\LogicException) {
            }
        }

        $path = parse_url($pageProps['Preview']['files'][0]['file']['url'], PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = sprintf('%s.%s', md5($path), $extension);
        if (!Storage::exists('public/widget/'.$fileName)) {
            Storage::put(
                'public/widget/'.$fileName,
                file_get_contents($pageProps['Preview']['files'][0]['file']['url'])
            );
        }

        $this->widget->fill([
            'name' => $pageProps['Name']['title'][0]['plain_text'],
            'title' => $pageProps['Meta title']['rich_text'][0]['plain_text'],
            'desc' => $pageProps['Meta description']['rich_text'][0]['plain_text'],
            'slug' => $pageProps['Slug']['rich_text'][0]['plain_text'],
            'preview' => asset('storage/widget/'.$fileName),
            'page_object' => $page,
            'html' => $page->render()->implode(''),
            'notion_page_id' => $this->pageId
        ]);

        $this->widget->tags()->sync($tags->pluck('id'));
        $this->widget->save();

        return [
            'widget' => $this->widget
        ];
    }

    private function uploadResponsiveImages(array $files, string $folder): array
    {
        $allowedSizes = [
            'desktop',
            'mobile',
        ];

        $responsiveImages = [];

        foreach ($files as $i => $file) {
            $responsiveImages[] = [
                'path' => $this->uploadImage($file, $folder),
                'device' => $allowedSizes[$i]
            ];
        }

        return $responsiveImages;
    }

    private function uploadImage(array $file, string $folder): string
    {
        $path = parse_url($file['file']['url'], PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = sprintf('%s.%s', md5($path), $extension);
        if (!Storage::exists('public/'.$folder.'/'.$fileName)) {
            Storage::put(
                'public/'.$folder.'/'.$fileName,
                file_get_contents($file['file']['url'])
            );
        }

        return asset('storage/'.$folder.'/'.$fileName);
    }

    /**
     * @param  string  $pageId
     */
    public function setPageId(string $pageId): void
    {
        $this->pageId = $pageId;
    }

    /**
     * @param  Template  $template
     */
    public function setTemplate(Template $template): void
    {
        $this->template = $template;
    }

    /**
     * @param  BlogPost  $blogPost
     */
    public function setBlogPost(BlogPost $blogPost): void
    {
        $this->blogPost = $blogPost;
    }

    /**
     * @param  Widget  $widget
     */
    public function setWidget(Widget $widget): void
    {
        $this->widget = $widget;
    }

    /**
     * @param  Kit  $kit
     */
    public function setKit(Kit $kit): void
    {
        $this->kit = $kit;
    }
}
