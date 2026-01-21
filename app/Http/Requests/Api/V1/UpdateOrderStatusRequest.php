<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $order = $this->route('order');

        return $this->user()->can(
            'update',
            [$order, $this->status]
        );
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'string'],
        ];
    }
}
