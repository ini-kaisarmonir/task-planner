<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Priority;
use App\Enums\Status;
use Illuminate\Validation\Rules\Enum;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'user_id'           => 'required|exists:users,id',
            'priority'         => ['nullable', new Enum(Priority::class)],
            'status'           => ['nullable', new Enum(Status::class)],
            'due_at'           => 'required|date|after:now',
        ];
    }
}
