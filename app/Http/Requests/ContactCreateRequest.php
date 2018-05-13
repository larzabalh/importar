<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

class ContactCreateRequest extends FormRequest
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
      $idCountry = Input::get("idCountry");
      $personalID = Input::get('personalID');

        return [
    'idCountry' => 'required|unique:pgsql_people.tPersonalFiles,idCountry,NULL,idPersonalFile,personalID,'.$personalID.'',
    'personalID'
   => 'required|numeric|digits_between:4,9|unique:pgsql_people.tPersonalFiles,personalID,NULL,idPersonalFile,idCountry,'.$idCountry.'',
    'alternativePersonalID' => 'required_without_all:personalID',
    'firstName' => 'required|string',
    'lastName' => 'required|string',
    'idRelationType' => 'required',
    'idCountryResidence' => 'required',
    'idState' => 'required',
    'addressContact' => 'required|string',
    'localPhoneNumber' => 'nullable|string',
    'mobilePhoneNumber' => 'nullable|string',
    'principalEmail' => 'nullable|email'
        ];
    }

    /**
     * [messages description]
     * @return [type] [description]
     */
    public function messages()
    {
        return [
            'personalID' => 'Documento inválido',
            'personalID.unique'   => 'Este Documento ya está registrado',
        ];
    }


    /**
     * [attributes description]
     * @return [type] [description]
     */
    public function attributes()
    {
        return [
            'personalID' => 'Documento',
            'idCountry' => 'Nacionalidad',
            'alternativePersonalID' => 'Precaria o Temporal',
            'firstName' => 'Nombres',
            'lastName' => 'Apellidos',
            'idRelationType' => 'Parentesco',
            'idCountryResidence' => 'Pais de Residencia',
            'idState' => 'Estado / Provincia',
            'addressContact' => 'Direccion de Residencia',
            'localPhoneNumber' => 'Telefono Local',
            'mobilePhoneNumber' => 'Telefono Movil',
            'principalEmail' => 'Email'
        ];
    }
}
