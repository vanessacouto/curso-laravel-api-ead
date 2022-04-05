<?php

namespace App\Http\Requests;

use App\Models\Support;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupport extends FormRequest
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
    public function rules(Support $support)
    {
        return [
            'lesson' => ['required', 'exists:lessons,id'], // valor obrigatorio e esse valor deve existira na coluna 'id' da tabela 'lessons'
            'status' => [
                'required',
                 Rule::in(array_keys($support->statusOptions)) // pega as 'keys' do array, ou seja: 'A', 'P', 'C'
            ], // valor obrigatorio e verifica se o valor é 'A', 'P', 'C'
            'description' => ['required', 'min:3', 'max:10000']
        ];
    }
}
