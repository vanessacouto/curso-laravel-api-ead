<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplySupport extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => ['required', 'min:3', 'max:10000'],
            'support_id' => ['required', 'exists:reply_support,support_id'], // o valor deve existir no campo 'support_id' na tabela 'reply_support'
        ];
    }
}
