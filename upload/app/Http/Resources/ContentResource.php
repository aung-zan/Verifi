<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * content's id.
             *
             * @var int
             *
             * @example 1
             */
            'id' => $this->id,
            /**
             * content's user_id.
             *
             * @var int
             *
             * @example 1
             */
            'user_id' => $this->user_id,
            /**
             * content.
             *
             * @var string
             *
             * @example Last night, someone died in the car accident.
             */
            'content' => $this->content,
            /**
             * content's status.
             *
             * @var string
             *
             * @example success
             */
            'status' => $this->status,
            /**
             * content's result.
             *
             */
            'result' => new ContentResultResource($this->result),
            /**
             * content's created_at.
             *
             * @var string
             *
             * @format datetime
             *
             * @example 2025-07-20 06:00:00
             */
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            /**
             * content's updated_at.
             *
             * @var string
             *
             * @format datetime
             *
             * @example 2025-07-20 06:00:00
             */
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
