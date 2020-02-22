<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReviewResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        //这个是单独展示每条review的，而且它是和reviewController在一起的
        return [
            'id' => $this->id,
            'customer' => $this->customer,
            'body' => $this->review,
            'star' => $this->star
        ];
    }
}
