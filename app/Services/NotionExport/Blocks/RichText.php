<?php

namespace App\Services\NotionExport\Blocks;

use Illuminate\Support\Stringable;

class RichText
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Stringable
     */
    public function getText(): Stringable
    {
        return str($this->text);
    }

    /**
     * @return ?array
     */
    public function getLink(): ?array
    {
        return $this->link;
    }

    /**
     * @return bool
     */
    public function isBold(): bool
    {
        return $this->bold;
    }

    /**
     * @return bool
     */
    public function isItalic(): bool
    {
        return $this->italic;
    }

    /**
     * @return bool
     */
    public function isStrikethrough(): bool
    {
        return $this->strikethrough;
    }

    /**
     * @return bool
     */
    public function isUnderline(): bool
    {
        return $this->underline;
    }

    /**
     * @return bool
     */
    public function isCode(): bool
    {
        return $this->code;
    }

    /**
     * @return bool
     */
    public function isColor(): bool
    {
        return $this->color;
    }

    protected string $type;

    protected string $text;

    protected ?array $link;

    /*
    |--------------------------------------------------------------------------
    | Annotations
    |--------------------------------------------------------------------------
    |
    | This options need for handle plain text.
    |
    */

    protected bool $bold;

    protected bool $italic;

    protected bool $strikethrough;

    protected bool $underline;

    protected bool $code;

    protected string $color;

    public function __construct(array $data)
    {
        $this->type = $data['type'];
        $this->text = $data['text']['content'];
        $this->link = $data['text']['link'];

        foreach ($data['annotations'] as $key => $value) {
            $this->$key = $value;
        }
    }
}
