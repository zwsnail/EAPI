<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReviewResourceShow extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */

    

    public function toArray($request)
    {
        // return $request;
        return [
            // 'id'=> $this->product_id, 
            // 'product_id' => $this->product_id,
            // 'id' => $this->id,

            // 'posts' => PostResource::collection($this->posts),
            'customer' => $this->customer,
            'body' => $this->review,
            'star' => count('star') > 0 ? $this->star : 'No rating yet'
        ];
    }
}
