<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class BusinessCreateRequest extends FormRequest
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
      /*  'document' => [ 'required', Rule::unique('persons')->ignore($person_id, 'id')
          ->where(function ($query) use($document_type) {
            return $query->where('document_type', $document_type)
            ->whereNotIn('persons.id',
              Persons::where()->->get();
            })
          ],*/
        'document' => 'required|unique:v_business,document,'.$person_id.
          ',id,document_type,'.$document_type,
        'field_name1' => 'required',

        "person_type_id" =>  'required',
        "iva_condition_id" =>  'required',
        "month_close" =>  'required',
        "activity_quantity" =>  'required|min:1',
        "zone_quantity" =>  'required|min:1',
        "obligation_iibb" =>  'required',
        //"obligation_other_taxes" =>  'required',
        //"settle_calc_by_coef" =>  'required',
        "liquidator_quantity" =>  'required|min:1',

        'sifere_coef.*' => 'required|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,5}$/',
        'iibb_aliquot.*' => 'required|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/',

        /*'number' => 'required|numeric',
        'type_receipt_id' => 'required|integer',
        'zone_id' => 'integer',
        'status_id' => 'required',
        'zone_id' => 'required',
        'activity_id' => 'required',
        'amount.*' => 'nullable|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/'*/
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
          'document.unique' => 'Ya está registrada ésta Empresa',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'integer' => 'Requerido',
          'activity_quantity' => 'Seleccione al menos uno',
          'zone_quantity' => 'Seleccione al menos uno',
          'liquidator_quantity' => 'Seleccione al menos uno',

          'sifere_coef.*' => 'Invalido',
          'iibb_aliquot.*' => 'Invalido',
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

          "person_type_id" =>  'Tipo de Persona',
          "iva_condition_id" =>  'Condicion de Iva',
          "month_close" =>  'Mes de Cierre',
    			"activity_quantity" =>  'Cantidad de Actividades',
    			"zone_quantity" =>  'Cantidad de Zonas',
    			"obligation_iibb" =>  'Tipo de IIBB',
    			"obligation_other_taxes" =>  'Tipo de Otros Impuestos',
    			"settle_calc_by_coef" =>  'Calculo de IIBB',
    			"liquidator_quantity" =>  'Cantidad de Liquidadores',

          'sifere_coef' => 'Coeficiente',
          'iibb_aliquot' => 'Aliquota',
        ];
    }
}
