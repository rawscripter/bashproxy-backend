<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->name,
            'total_orders' => $this->orders->count(),
            'discord_id' => $this->discord_id,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
        ];
    }
}
