<?php

namespace App\Services\Notion\Pages;

use App\Services\Notion\Contracts\PropertyInterface;
use App\Services\Notion\Pages\Properties\PropertyData;
use Carbon\Carbon;

class PageData
{
    public string $id;

    public Carbon $createdTime;

    public Carbon $lastEditedTime;

    public ParentPageData $parent;

    public bool $archived;

    /**
     * @var PropertyInterface[]
     */
    public array $properties;

    public string $url;

    public static function fromArray(array $data): self
    {
        $pageData = new self();

        $properties = [];

        foreach ($data['properties'] as $propertyName => $propertyData) {
            try {
                $properties[$propertyName] = PropertyData::fromArray($propertyName, $propertyData);
            } catch (\LogicException) {
            }
        }

        $pageData->setId($data['id']);
        $pageData->setCreatedTime(Carbon::parse($data['created_time']));
        $pageData->setLastEditedTime(Carbon::parse($data['last_edited_time']));
        $pageData->setParent(ParentPageData::fromArray($data['parent']));
        $pageData->setProperties($properties);
        $pageData->setUrl($data['url']);
        $pageData->setArchived($data['archived']);

        return $pageData;
    }

    public function toArray(array $only = []): array
    {
        $data = [];

        if (isset($this->id)) {
            $data['id'] = $this->id;
        }

        if (isset($this->createdTime)) {
            $data['created_time'] = $this->createdTime->toIso8601String();
        }

        if (isset($this->lastEditedTime)) {
            $data['last_edited_time'] = $this->lastEditedTime->toIso8601String();
        }

        if (isset($this->archived)) {
            $data['archived'] = $this->archived;
        }

        if (isset($this->properties)) {
            $props = [];

            foreach ($this->properties as $property) {
                $props = array_merge($props, $property->toArray());
            }

            $data['properties'] = array_filter($props);
        }

        if (isset($this->parent)) {
            $data['parent'] = $this->parent->toArray();
        }

        if (isset($this->url)) {
            $data['url'] = $this->url;
        }

        if (empty($only)) {
            return $data;
        }

        return collect($data)
            ->only($only)
            ->toArray();
    }

    public function getPropertiesByKey(): array
    {
        $data = [];

        foreach ($this->properties as $property) {
            $data[$property->key] = $property;
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Carbon
     */
    public function getCreatedTime(): Carbon
    {
        return $this->createdTime;
    }

    /**
     * @param Carbon $createdTime
     */
    public function setCreatedTime(Carbon $createdTime): void
    {
        $this->createdTime = $createdTime;
    }

    /**
     * @return Carbon
     */
    public function getLastEditedTime(): Carbon
    {
        return $this->lastEditedTime;
    }

    /**
     * @param Carbon $lastEditedTime
     */
    public function setLastEditedTime(Carbon $lastEditedTime): void
    {
        $this->lastEditedTime = $lastEditedTime;
    }

    /**
     * @return ParentPageData
     */
    public function getParent(): ParentPageData
    {
        return $this->parent;
    }

    /**
     * @param ParentPageData $parent
     */
    public function setParent(ParentPageData $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->archived;
    }

    /**
     * @param bool $archived
     */
    public function setArchived(bool $archived): void
    {
        $this->archived = $archived;
    }

    public function getArchived(): bool
    {
        return $this->archived;
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
