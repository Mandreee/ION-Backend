<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsSubTopicsResource extends JsonResource
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
            "id" => $this->id,
            "sub_topic_titlte" => $this->sub_topic_title,
            "added_at" => $this->added_at,
            "updated_at" => $this->updated_at,
            "topic" => new NewsSubTopicsResource($this->news_topics)
        ];
    }
}
