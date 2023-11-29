<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Template;
use App\Models\Widget;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SitemapGenerateCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Command description';

    protected array $items = [];

    public function handle()
    {
        $this->pushItem(['loc' => '', 'lastmod' => now()->format('c')]);
        $this->pushItem(['loc' => 'template-library', 'lastmod' => now()->format('c')]);
        $this->pushItem(['loc' => 'blog', 'lastmod' => now()->format('c')]);

        Template::query()
            ->select('slug', 'updated_at')
            ->published()
            ->get()
            ->each(
                fn($item) => $this->pushItem(
                    ['loc' => 'template/'.$item->slug, 'lastmod' => $item->updated_at->format('c')]
                )
            );

        BlogPost::query()
            ->select('slug', 'updated_at')
            ->published()
            ->get()
            ->each(
                fn($item) => $this->pushItem(
                    ['loc' => 'blog/'.$item->slug, 'lastmod' => $item->updated_at->format('c')]
                )
            );

        Widget::query()
            ->select('slug', 'updated_at')
            ->published()
            ->get()
            ->each(
                fn($item) => $this->pushItem(
                    ['loc' => 'widgets/'.$item->slug, 'lastmod' => $item->updated_at->format('c')]
                )
            );

//        Tag::select(['slug', 'updated_at'])
//            ->has('templates')
//            ->get()
//            ->each(fn($item) => $this->pushItem(['loc' => $item->slug, 'lastmod' => $item->updated_at->format('c')]));

        $content = '<?xml version = "1.0" encoding = "UTF-8"?>';

        $content .= view('sitemap', ['items' => $this->items])->render();

        File::makeDirectory(public_path('sitemaps'), force: true);
        File::put(public_path('sitemaps/sitemap.xml'), $content);

        return Command::SUCCESS;
    }

    private function pushItem(array $item): void
    {
        $item['loc'] = 'https://notionism.org/'.$item['loc'];

        $this->items[] = $item;
    }
}
