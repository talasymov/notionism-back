<?php

namespace App\Services\Notion\Pages;

use App\Exceptions\NotionFailedCreatePage;
use App\Exceptions\NotionFailedDeletePage;
use App\Exceptions\NotionFailedFindAll;
use App\Exceptions\NotionFailedUpdatePage;
use App\Services\Notion\Common\ResourceAbstract;
use App\Services\Notion\NotionClient;
use Illuminate\Http\Client\Response;

class Page extends ResourceAbstract
{
    public function create(PageData $pageData): PageData
    {
        $response = $this->client->post('pages', $pageData->toArray());

        if ($response->failed()) {
            throw new NotionFailedCreatePage();
        }

        return PageData::fromArray($response->json());
    }

    public function update(PageData $pageData): PageData
    {
        $response = $this->client->patch('pages/' . $pageData->id, $pageData->toArray(['properties']));

        if ($response->failed()) {
            throw new NotionFailedUpdatePage();
        }

        return PageData::fromArray($response->json());
    }

    public function delete(PageData $pageData): Response
    {
        $pageData->archived = true;
        $response = $this->client->patch('pages/' . $pageData->id, $pageData->toArray(['archived']));

        if ($response->failed()) {
            throw new NotionFailedDeletePage();
        }

        return $response;
    }

    /**
     * @return PageData[]
     * @throws NotionFailedFindAll
     */
    public function findAll(string $databaseId, array $filter = []): array
    {
        $response = $this->client->getRequest()
            ->when(
                empty($filter),
                fn($q) => $q->withBody('{}', 'application/json')
            )
            ->post(NotionClient::API_ENDPOINT . 'databases/' . $databaseId . '/query', $filter);

        if ($response->failed()) {
            throw new NotionFailedFindAll();
        }

        $pages = $response->json('results');

        if (($filter['page_size'] ?? 100) === 1) {
            return array_map(fn($page) => PageData::fromArray($page), $pages);
        }

        while ($response->json('has_more')) {
            $response = $this->client->getRequest()
                ->post(
                    NotionClient::API_ENDPOINT . 'databases/' . $databaseId . '/query',
                    array_merge($filter, ['start_cursor' => $response->json('next_cursor')])
                );

            if ($response->failed()) {
                throw new NotionFailedFindAll();
            }

            $pages = array_merge($pages, $response->json('results'));
        }

        // TODO attempts

        return array_map(fn($page) => PageData::fromArray($page), $pages);
    }
}
