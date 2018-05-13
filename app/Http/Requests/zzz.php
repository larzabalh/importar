<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

use Carbon\Carbon;

class zzz extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * For rules types of validation
     * return array
     */
    private function typeRules($type_id){
      $arr = [];

      $person_id_relationed = Input::get("person_id_relationed");
      $number = Input::get("number");

      $receipt_id = (Input::get('receipt_id')!==null)
      ? Input::get('receipt_id') : "NULL";

      if ($type_id==1){
        $arr =   [
          'period_code' => 'required',
          'receipt_date' => 'required|date',
          'expiration_date' => 'nullable|date',
          'client_name' => 'required',
          'code_ticket' => 'required|numeric|unique:receipts'
          .',code_ticket'.','.$receipt_id.',id'.',type_id,'.$type_id
          .',number,'.$number.',person_id_relationed,'.$person_id_relationed.'',
          'number' => 'required|numeric',
          'type_receipt_id' => 'required|integer',
          'zone_id' => 'integer',
          'status_id' => 'required',
          'zone_id' => 'required',
          'activity_id' => 'required',
          'amount.*' => 'nullable|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/'
        ];
      }else
      if ($type_id==2){
        $arr =   [
          'period_code' => 'required',
          'receipt_date' => 'required|date',
          'client_name' => 'required',
          'code_ticket' => 'required|numeric|unique:receipts'
          .',code_ticket'.','.$receipt_id.',id'.',type_id,'.$type_id
          .',number,'.$number.',person_id_relationed,'.$person_id_relationed.'',
          'number' => 'required|numeric',
          'type_receipt_id' => 'required|integer',
          'amount.*' => 'nullable|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/'
        ];
      }else
      if ($type_id==3){
        $arr =   [
          'period_code' => 'required',
          'receipt_date' => 'required|date',
          'client_name' => 'required',
          'code_ticket' => 'required|numeric|unique:receipts'
          .',code_ticket'.','.$receipt_id.',id'.',type_id,'.$type_id
          .',number,'.$number.',person_id_relationed,'.$person_id_relationed.'',
          'number' => 'required|numeric',
          'type_receipt_id' => 'required|integer',
          'amount' => 'required|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/',
          'retention_type_id' => 'required',
          'reference' => 'required|numeric'
        ];
      }else
      if ($type_id==4){
        $arr =   [
          'period_code' => 'required',
          'amount' => 'required|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/',
          'zone_id' => 'required'
        ];
      }else
      if ($type_id==5){
        $arr =   [
          'period_code' => 'required',
          'receipt_date' => 'required|date',
          'amount' => 'required|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/',
          'reference' => 'required|numeric'
        ];
      }else
      if ($type_id==6){
        $arr =   [
          'period_code' => 'required',
          'receipt_date' => 'required|date',
          'amount' => 'required|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/',
          'reference' => 'required|numeric'
        ];
      }

      return $arr;
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
        'document' => 'required|unique:persons'
          .$document.','.$person_id.',id'.',document_type,'.$document_type,
        'field_name1' => 'required',
        'client_name' => 'required',

        "person_type_id" =>  'required',
        "iva_condition_id" =>  'required',
        "month_close" =>  'required'
  			"activity_quantity" =>  'required|min:1',
  			"zone_quantity" =>  'required|min:1',
  			"obligation_iibb" =>  'required',
  			"obligation_other_taxes" =>  'required',
  			"settle_calc_by_coef" =>  'required',
  			"liquidator_quantity" =>  'required|min:1',

        'sifere_coef.*' => 'required|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/',
        'iibb_aliquot.*' => 'required|numeric',

        /*'number' => 'required|numeric',
        'type_receipt_id' => 'required|integer',
        'zone_id' => 'integer',
        'status_id' => 'required',
        'zone_id' => 'required',
        'activity_id' => 'required',
        'amount.*' => 'nullable|regex:/^[0-9]{1,9}\,{0,1}[0-9]{0,3}$/'*/
      ];;
    }



    private function typeMessages($type_id){
      $arr = [];
      if ($type_id==1){
        $arr = [
          'period_code' => 'Seleccione el Periodo',
          'code_ticket.unique' => 'Ya está registrado este comprobante para ésta
          Empresa',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'integer' => 'Requerido',
          'amount' => 'Al menos uno de ellos'
        ];
      }else
      if ($type_id==2){
        $arr = [
          'period_code' => 'Seleccione el Periodo',
          'code_ticket.unique' => 'Ya está registrado este comprobante para ésta
          Empresa',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'integer' => 'Requerido',
          'amount' => 'Al menos uno de ellos'
        ];
      }else
      if ($type_id==3){
        $arr = [
          'period_code' => 'Seleccione el Periodo',
          'code_ticket.unique' => 'Ya está registrado este comprobante para ésta
          Empresa',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'integer' => 'Requerido',
          'amount' => 'Monto inválido',
          'numeric' => 'Sólo números permtidos'
        ];
      }else
      if ($type_id==4){
        $arr = [
          'period_code' => 'Seleccione el Periodo',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'integer' => 'Requerido',
          'amount' => 'Monto inválido',
          'numeric' => 'Sólo números permtidos'
        ];
      }else
      if ($type_id==5){
        $arr = [
          'period_code' => 'Seleccione el Periodo',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'integer' => 'Requerido',
          'amount' => 'Monto inválido',
          'numeric' => 'Sólo números permtidos'
        ];
      }else
      if ($type_id==6){
        $arr = [
          'period_code' => 'Seleccione el Periodo',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'integer' => 'Requerido',
          'amount' => 'Monto inválido',
          'numeric' => 'Sólo números permtidos'
        ];
      }

      return $arr;
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

          'sifere_coef' => 'Invalido',
          'iibb_aliquot' => 'Invalido',

        ];
    }



    private function typesAttributes($type_id){
      $arr = [];
      if ($type_id==1){
        $arr = [
          'period_code' => 'Periodo',
          'receipt_date' => 'Fecha',
          'expiration_date' => 'Expiracion',
          'client_name' => 'Cliente',
          'code_ticket' => 'Punto de Venta',
          'number' => 'Numero',
          'type_receipt_id' => 'Tipo de Comprobante',
          'zone_id' => 'Zona',
        ];
      }else
      if ($type_id==2){
        $arr = [
          'period_code' => 'Periodo',
          'receipt_date' => 'Fecha',
          'client_name' => 'Proveedor',
          'code_ticket' => 'Punto de Venta',
          'number' => 'Numero',
          'type_receipt_id' => 'Tipo de Comprobante',
        ];
      }else
      if ($type_id==3){
        $arr = [
          'period_code' => 'Periodo',
          'receipt_date' => 'Fecha',
          'client_name' => 'Cliente',
          'code_ticket' => 'Punto de Venta',
          'number' => 'Numero',
          'type_receipt_id' => 'Tipo de Comprobante',
          'amount' => 'Monto',
          'retention_type_id' => 'Tipo',
          'reference' => 'Referencia'
        ];
      }else
      if ($type_id==4){
        $arr = [
          'period_code' => 'Periodo',
          'zone_id' => 'Zona',
          'amount' => 'Monto',
        ];
      }else
      if ($type_id==5){
        $arr = [
          'period_code' => 'Periodo',
          'receipt_date' => 'Fecha',
          'amount' => 'Monto',
          'reference' => 'Referencia'
        ];
      }else
      if ($type_id==6){
        $arr = [
          'period_code' => 'Periodo',
          'receipt_date' => 'Fecha',
          'amount' => 'Monto',
          'reference' => 'Referencia'
        ];
      }

      return $arr;
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
          "month_close" =>  'Mes de Cierre'
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



    public function requestInputs($type_id, $person, $systemTaxes, $otherTaxes){
      $arr = [];
      $total = 0;
      if ($type_id['type_id']==1){
        $arr =  $this->only([
          'period_id', 'receipt_date', 'expiration_date', 'person_id_relationed' ,
          'code_ticket' , 'number' , 'type_receipt_id' , 'zone_id',
          'activity_id', 'type_id', 'receipt_id',
        ]);

        $arr['receipt_date'] = Carbon::createFromFormat('Y-m-d', $arr['receipt_date']);
        //return(\Response::json(['respuesta' => $data ] ));
        $arr['expiration_date'] = strlen($arr['expiration_date'])>0
          ? Carbon::createFromFormat('Y-m-d', $arr['expiration_date']) :
           $arr['receipt_date'] ;
        $arr['zone_id'] = strlen($arr['zone_id'])>0 ? $arr['zone_id'] :
          ( ($person['zone_id']) ? $person['zone_id'] : null);
        $arr['status_id'] = isset($arr['status_id']) ? $arr['status_id'] : 1;

        //sum for total receipt
        $total = collect($systemTaxes['amount'])->sum()
                + collect($systemTaxes['iva_amount'])->sum();
        $total += collect($otherTaxes['amount_other'])->sum();

        $arr['amount'] = $total;
      }else
      if ($type_id['type_id']==2){
        $arr =  $this->only([
          'period_id', 'receipt_date', 'person_id_relationed' ,
          'code_ticket' , 'number' , 'type_receipt_id', 'type_id', 'receipt_id',
        ]);

        $arr['receipt_date'] = Carbon::createFromFormat('Y-m-d', $arr['receipt_date']);
        //return(\Response::json(['respuesta' => $data ] ));
        $arr['status_id'] = 1;

        //sum for total receipt
        $total = collect($systemTaxes['amount'])->sum()
                + collect($systemTaxes['iva_amount'])->sum();
        $total += collect($otherTaxes['amount_other'])->sum();

        $arr['amount'] = $total;
      }else
      if ($type_id['type_id']==3){
        $arr =  $this->only([
          'period_id', 'receipt_date', 'person_id_relationed' ,
          'code_ticket' , 'number' , 'type_receipt_id', 'type_id', 'receipt_id',
          'retention_type_id', 'reference', 'amount'
        ]);

        $arr['amount'] = str_replace(',', '.', $arr['amount']);

        $arr['receipt_date'] = Carbon::createFromFormat('Y-m-d', $arr['receipt_date']);
        //return(\Response::json(['respuesta' => $data ] ));
        $arr['status_id'] = 1;
      }else
      if ($type_id['type_id']==4){
        $arr =  $this->only([
          'period_id', 'receipt_id', 'amount', 'zone_id', 'type_id'
        ]);

        $arr['amount'] = str_replace(',', '.', $arr['amount']);

        $arr['status_id'] = 1;
      }else
      if ($type_id['type_id']==5){
        $arr =  $this->only([
          'period_id', 'receipt_date', 'type_id', 'receipt_id',
           'reference', 'amount'
        ]);
        $arr['amount'] = str_replace(',', '.', $arr['amount']);

        $arr['receipt_date'] = Carbon::createFromFormat('Y-m-d', $arr['receipt_date']);
        //return(\Response::json(['respuesta' => $data ] ));
        $arr['status_id'] = 1;
      }else
      if ($type_id['type_id']==6){
        $arr =  $this->only([
          'period_id', 'receipt_date', 'type_id', 'receipt_id',
           'reference', 'amount'
        ]);
        $arr['amount'] = str_replace(',', '.', $arr['amount']);

        $arr['receipt_date'] = Carbon::createFromFormat('Y-m-d', $arr['receipt_date']);
        //return(\Response::json(['respuesta' => $data ] ));
        $arr['status_id'] = 1;
      }

      return $arr;
    }

    public function requestInputsSystemTaxes($type_id){
      $arr = [];
      if ($type_id['type_id']==1){
        $arr =  $this->only([
          'amount', 'iva_amount', 'iva', 'taxable_iibb',
        ]);
      }else
      if ($type_id['type_id']==2){
        $arr =  $this->only([
          'amount', 'iva_amount', 'iva', 'taxable_iibb',
        ]);
      }
      return $arr;
    }

    public function requestInputsOtherTaxes($type_id){
      $arr = [];
      if ($type_id['type_id']==1){
        $arr =  $this->only([
          'amount_other', 'apply_to',
        ]);
      }else
      if ($type_id['type_id']==2){
        $arr =  $this->only([
          'amount_other', 'apply_to',
        ]);
      }
      return $arr;
    }
}
