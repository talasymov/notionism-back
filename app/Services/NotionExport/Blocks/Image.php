<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Contracts\FileInterface;
use Illuminate\Support\Facades\Storage;

class Image extends AbstractBlock implements FileInterface
{
    public function render(): string
    {
        $path = parse_url($this->getFile()['url'], PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = sprintf('%s.%s', md5($path), $extension);

        if (!Storage::exists('public/template/' . $fileName)) {
            Storage::put('public/template/' . $fileName, file_get_contents($this->getFile()['url']));
        }

        return sprintf(
            '<div class="notion-image"><img src="%s" alt="%s"></div>',
            asset('storage/template/' . $fileName),
            $this->getCaption() ?? 'Image alt'
        );
    }
}
