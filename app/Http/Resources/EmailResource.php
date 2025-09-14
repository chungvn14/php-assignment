<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource
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
            'email' => $this->email,
            'subject' => $this->subject,
            'body' => $this->body,
            'attachment_path' => $this->attachment_path ? asset('storage/' . $this->attachment_path) : null,
            'status' => $this->status,
            'attempts' => $this->attempts,
            'created_at' => $this->created_at,
        ];
    }
}
