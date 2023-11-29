<?php

namespace App\Http\Resources\Widget;

use Illuminate\Http\Resources\Json\JsonResource;

class WidgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'desc' => mb_strlen($this->desc) > 90 ? mb_substr($this->desc, 0, 90).'...' : $this->desc,
            'preview' => $this->preview,
            'codename' => $this->codename,
            'created_at' => $this->created_at,
        ];
    }
}
