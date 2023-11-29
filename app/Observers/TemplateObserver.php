<?php

namespace App\Observers;

use App\Models\Template;
use App\Models\TemplateHistory;

class TemplateObserver
{
    public function created(Template $template): void
    {
        $this->writeInHistory($template);
    }

    public function updated(Template $template): void
    {
        $this->writeInHistory($template);
    }

    private function writeInHistory(Template $template): void
    {
        $data = collect($template->getAttributes())
            ->except(['id'])
            ->put('template_id', $template->id)
            ->toArray();

        TemplateHistory::create($data);
    }
}
