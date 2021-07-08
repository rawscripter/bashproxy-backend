<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user' => $this->user,
            'customer_email' => $this->customer_email,
            'discount_code' => $this->discount_code,
            'paid_amount' => $this->paid_amount,
            'currency' => $this->currency,
            'product_price' => $this->product_price,
            'product_id' => $this->product_id,
            'discount_amount' => $this->discount_amount,
            'is_paid' => $this->is_paid,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at->format('d F Y H:i:s'),
        ];
    }
}
