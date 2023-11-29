<?php

namespace App\Services\Automation\NotionGoogleCalendarTwoWaySync;

class SyncConfig
{
    private string $notionDatabaseId;

    private string $calendarName;

    private MappingConfig $mapping;

    /**
     * @param string $notionDatabaseId
     * @return SyncConfig
     */
    public function setNotionDatabaseId(string $notionDatabaseId): self
    {
        $this->notionDatabaseId = $notionDatabaseId;

        return $this;
    }

    /**
     * @param string $notionDatabaseUrl
     */
    public function setNotionDatabaseIdFromUrl(string $notionDatabaseUrl): self
    {
        $this->notionDatabaseId = last(explode('/', parse_url($notionDatabaseUrl, PHP_URL_PATH)));

        return $this;
    }

    /**
     * @return string
     */
    public function getNotionDatabaseId(): string
    {
        return $this->notionDatabaseId;
    }

    /**
     * @return MappingConfig
     */
    public function getMapping(): MappingConfig
    {
        return $this->mapping;
    }

    /**
     * @param MappingConfig $mapping
     */
    public function setMapping(MappingConfig $mapping): self
    {
        $this->mapping = $mapping;

        return $this;
    }

    /**
     * @return string
     */
    public function getCalendarName(): string
    {
        return $this->calendarName;
    }

    /**
     * @param string $calendarName
     */
    public function setCalendarName(string $calendarName): self
    {
        $this->calendarName = $calendarName;

        return $this;
    }
}
