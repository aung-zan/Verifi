<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResultResource extends JsonResource
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
             * result's id.
             *
             * @var int
             *
             * @example 1
             *
             */
            'id' => $this->id,
            /**
             * result's content_id.
             *
             * @var int
             *
             * @example 1
             *
             */
            'content_id' => $this->content_id,
            /**
             * result
             *
             * @var string
             *
             * @example Unproven.
             *
             */
            'result' => $this->result,
            /**
             * result's summary
             *
             * @var string
             *
             * @example rolem alsum rolem alsum rolem alsum rolem alsum.
             */
            'summary' => $this->summary,
            /**
             * result's citations.
             *
             * @var string
             *
             * @example https://www.google.com
             */
            'citations' => $this->citations,
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
