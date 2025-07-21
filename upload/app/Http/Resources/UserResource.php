<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
             * user's id.
             *
             * @var int
             *
             * @example 1
             */
            'id' => $this->id,
            /**
             * user's name.
             *
             * @var string
             *
             * @example tester 1
             */
            'name' => $this->name,
            /**
             * user's email.
             *
             * @var string
             *
             * @example test@mail.com
             */
            'email' => $this->email,
            /**
             * user's sonar key.
             *
             * @var string
             *
             * @example eyJ0eXAiOiJKV1QiLCJhb...
             */
            'sonar_key' => $this->sonar_key,
            /**
             * user's created_at.
             *
             * @var string
             *
             * @format datetime
             *
             * @example 2025-07-20 06:00:00
             */
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            /**
             * user's updated_at.
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
