<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailRequestUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $emailId = $this->route('email')?->id ?? $this->route('id');

        return [
            'email' => [
                'required',
                'email',
                Rule::unique('emails', 'email')->ignore($emailId),
            ],
            'subject' => 'required|string|max:255',
            'body' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ];
    }
}
