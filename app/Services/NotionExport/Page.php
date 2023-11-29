<?php

namespace App\Services\NotionExport;

use App\Services\NotionExport\Blocks\BaseHeading;
use App\Services\NotionExport\Blocks\Lists\BaseListItem;
use App\Services\NotionExport\Blocks\Lists\EndList;
use App\Services\NotionExport\Blocks\Lists\StartList;
use App\Services\NotionExport\Contracts\BlockInterface;
use Illuminate\Support\Collection;

class Page
{
    private Collection $blocks;

    private static self $instance;

    public function __construct()
    {
        $this->blocks = collect();
    }

    public function pushBlock(BlockInterface $block): void
    {
        $block->setPage($this);

        $this->blocks->push($block);
    }

    public function render(): Collection
    {
        $this->preprocess();

        return $this
            ->blocks
            ->map(fn(BlockInterface $item) => $item->render());
    }

    private function preprocess(): void
    {
        $prev = null;
        $processed = collect();

        foreach ($this->blocks as $block) {
            if ($prev) {
                if (!($prev instanceof BaseListItem) && $block instanceof BaseListItem) {
                    $processed->push(new StartList($block));
                }

                if ($prev instanceof BaseListItem && !($block instanceof BaseListItem)) {
                    $processed->push(new EndList($prev));
                }
            } elseif ($block instanceof BaseListItem) {
                $processed->push(new StartList($block));
            }

            $processed->push($block);

            $prev = $block;
        }

        $this->blocks = $processed;
    }

    public function getHeaders(): Collection
    {
        return $this->blocks->filter(fn($item) => $item instanceof BaseHeading);
    }

    public static function getInstance(): self
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }

        self::$instance = new self();

        return self::getInstance();
    }
}
