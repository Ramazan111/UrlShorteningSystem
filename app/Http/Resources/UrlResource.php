<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UrlResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'original' => $this->original,
            'short_url' => $this->short_url,
            'clicks' => $this->clicks,
            'expire_at' => $this->expire_at,
        ];
    }
}
