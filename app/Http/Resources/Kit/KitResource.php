<?php

namespace App\Http\Resources\Kit;

use Illuminate\Http\Resources\Json\JsonResource;

class KitResource extends JsonResource
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
            'price' => $this->price,
            'likes' => $this->likes,
            'preview' => $this->preview,
            'responsive_images' => $this->responsive_images,
            'created_at' => $this->created_at,
        ];
    }
}
