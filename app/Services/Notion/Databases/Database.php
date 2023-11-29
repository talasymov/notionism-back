<?php

namespace App\Services\Notion\Databases;

use App\Services\Notion\Common\ResourceAbstract;
use Illuminate\Http\Client\Response;

class Database extends ResourceAbstract
{
    public function find(string $id): DatabaseData
    {
        return DatabaseData::fromArray($this->client->get('databases/'.$id)->json());
    }

    public function update(string $id, array $data): Response
    {
        return $this->client->patch('databases/'.$id, $data);
    }

    public function list(): array
    {
        $databases = $this->client->post('search', [
            'filter' => [
                'value' => 'database',
                'property' => 'object'
            ]
        ])
            ->json('results');

        return array_map(fn($database) => DatabaseData::fromArray($database), $databases);
    }
}
