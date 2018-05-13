<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class PersonCreateRequest extends FormRequest
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

      $document_type = Input::get("document_type");
      $document = Input::get("document");
      $person_id = (Input::get('person_id')!==null)
        ? Input::get('person_id') : "NULL";

      return [
        'document_type' => 'required',
        'document' => 'required|unique:persons,document,'.$person_id.
          ',id,document_type,'.$document_type,
        'field_name1' => 'required',
      ];
    }

    /**
     * [messages description]
     * @return [type] [description]
     */
    public function messages()
    {
        return [
          'document_type' => 'Seleccione',
          'document.unique' => 'Ya está registrada como Empresa, Cliente o Proveedor ',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'integer' => 'Requerido',
        ];
    }

    /**
     * [attributes description]
     * @return [type] [description]
     */
    public function attributes()
    {
        return [
          'document_type' => 'Tipo de Documento',
          'document' => 'Documento',
          'field_name1' => 'Nombre o Razon Social',
        ];
    }
}
