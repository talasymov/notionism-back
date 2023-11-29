<?php

namespace App\Services\NotionExport\Blocks\Helpers;

use App\Services\NotionExport\Blocks\RichText;
use Illuminate\Support\Collection;

class RichTextHelper
{
    public static function handle(Collection $richText): Collection
    {
        return $richText
            ->map(function (RichText $item) {
                $shingle = $item->getText();

                if (!empty($item->getLink())) {
                    if (str_contains($item->getLink()['url'], '/me.com')) {
                        $shingle = str(
                            sprintf(
                                '<a href="#%s">%s</a>',
                                str($item->getLink()['url'])->explode('#')->last(),
                                $item->getText()
                            )
                        );
                    } else {
                        $shingle = str(
                            sprintf('<a target="_blank" href="%s">%s</a>', $item->getLink()['url'], $item->getText())
                        );
                    }
                }

                if ($item->isCode()) {
                    $shingle = $shingle->wrap('<span class="notion-inline-code">', '</span>');
                }

                if ($item->isBold()) {
                    $shingle = $shingle->wrap('<span class="notion-inline-bold">', '</span>');
                }

                if ($item->isItalic()) {
                    $shingle = $shingle->wrap('<span class="notion-inline-italic">', '</span>');
                }

                if ($item->isStrikethrough()) {
                    $shingle = $shingle->wrap('<span class="notion-inline-strikethrough">', '</span>');
                }

                if ($item->isUnderline()) {
                    $shingle = $shingle->wrap('<span class="notion-inline-underline">', '</span>');
                }

                return str_replace("\n", '<br>', $shingle);
            });
    }
}
