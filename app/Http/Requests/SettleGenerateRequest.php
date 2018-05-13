<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

class SettleGenerateRequest extends FormRequest
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

      $period_id = Input::get("period_id");
      $apply_to = Input::get("apply_to");
      $person_id = session('current_person_id');

      $period_liquidation_id = (Input::get('period_liquidation_id')!==null)
      ? Input::get('period_liquidation_id') : 'NULL';

        return [
          'apply_to' => 'required|unique:period_liquidations'
          .',apply_to'.','.$period_liquidation_id.',id'.',period_id,'.$period_id
          .',status,2,person_id,'.$person_id.'',
          'period_id' => 'required',
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
          'apply_to.unique' => 'Ya fué generado y está cerrado',
          'period_id' => 'Seleccione el Periodo',
          'apply_to.required' => 'Seleccione el tipo',
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
          'period_id' => 'Periodo',
          'apply_to' => 'Tipo',
            //'amount' => 'Monto'
        ];
    }
}
