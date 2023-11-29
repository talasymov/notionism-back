<?php

namespace App\Services\Google\Contracts;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;

interface ClientInterface
{
    public function get(string $url): Response;

    public function post(string $url, array $data): Response;

    public function patch(string $url, array $data): Response;

    public function put(string $url, array $data): Response;

    public function delete(string $url): Response;

    public function getRequest(): PendingRequest;
}
