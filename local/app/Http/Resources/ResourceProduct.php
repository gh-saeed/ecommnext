<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceProduct extends JsonResource
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
            'id'=> $this->id,
            'off'=> $this->off,
            'price'=> $this->price,
            'image'=> $this->image,
            'count'=> $this->count,
            'type'=> $this->type,
            'slug'=> $this->slug,
            'offPrice'=> $this->offPrice,
            'imageAlt'=> $this->imageAlt,
            'colors'=> $this->colors,
            'lotteryStatus'=> $this->lotteryStatus,
            'title'=> $this->title,
            'inquiry'=> $this->inquiry,
            'ability'=> $this->ability,
            'short'=> $this->short,
        ];
    }
}
