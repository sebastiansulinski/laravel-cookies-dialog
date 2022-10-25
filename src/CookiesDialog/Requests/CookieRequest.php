<?php

namespace SSD\CookiesDialog\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $third_party
 */
class CookieRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'third_party' => [
                'required',
                'in:0,1',
            ],
        ];
    }
}
