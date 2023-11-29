<?php

namespace App\Services\NotionExport\Blocks;

use App\Services\NotionExport\Contracts\BlockInterface;
use App\Services\NotionExport\Contracts\DatabaseInterface;
use App\Services\NotionExport\Contracts\FileInterface;
use App\Services\NotionExport\Contracts\IconInterface;
use App\Services\NotionExport\Contracts\RichTextInterface;
use App\Services\NotionExport\Page;
use Illuminate\Support\Collection;

abstract class AbstractBlock implements BlockInterface
{
    protected ?string $id;

    protected bool $hasChildren;

    protected string $type;

    protected Collection $richText;

    protected string $plainText;

    protected Page $page;

    public function __construct(array $config = [])
    {
        $this->type = $config['type'];
        $this->id = $config['id'] ?? null;
        $this->hasChildren = $config['has_children'] ?? false;

        $data = $config[$this->type];

        if ($this instanceof RichTextInterface) {
            $this->richText = collect($data['rich_text'])->map(fn($item) => new RichText($item));
            $this->plainText = collect($data['rich_text'])->map(fn($item) => $item['plain_text'])->implode('');
        }

        if ($this instanceof DatabaseInterface) {
            $this->items = $data['items'];
        }

        if ($this instanceof FileInterface) {
            $this->file = $data['file'];
            if ($this instanceof Image) {
                $this->caption = $data['caption'];
            }
        }

        if ($this instanceof IconInterface) {
            $this->icon = $data['icon'];
        }
    }

    public function getRichText(): Collection
    {
        return $this->richText;
    }

    public function getPlainText(): string
    {
        return $this->plainText;
    }

    public function getPlainTextSlug(): string
    {
        return str($this->plainText)->slug();
    }

    public function getIcon(): array
    {
        return $this->icon;
    }

    public function getFile(): array
    {
        return $this->file;
    }

    public function getCaption(): ?string
    {
        return $this->caption[0]['plain_text'] ?? null;
    }

    public function type(): string
    {
        return $this->type;
    }

    /**
     * @param Page $page
     */
    public function setPage(Page $page): void
    {
        $this->page = $page;
    }
}
