<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

class SettleCreateRequest extends FormRequest
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
            //'amount.*' => 'nullable|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/'
        ];
    }

    /**
     * [messages description]
     * @return [type] [description]
     */
    public function messages()
    {
        return [
            //'amount'   => 'Debe ser en numérico',
        ];
    }


    /**
     * [attributes description]
     * @return [type] [description]
     */
    public function attributes()
    {
        return [
            //'amount' => 'Monto'
        ];
    }
}
