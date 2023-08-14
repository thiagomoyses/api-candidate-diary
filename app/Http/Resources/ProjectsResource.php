<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'job_reference' => $this->job_reference,
            'company_id' => $this->company_id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
