<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\PersonalFile;
use \App\Models\ForeignFile;
use \App\Models\ImmigrationSituation;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ReportConsularRegistry;

class ReportsController extends Controller
{
  public function reportPersonalFile($id){

    \Debugbar::disable();

    $personalFile = PersonalFile::find($id);

    $foreignFile = ForeignFile::where('idPersonalFile','=',$id)->first();
    if(!$foreignFile){ $foreignFile = new ForeignFile; }

    //dd($personalFile);
    $pdf = new ReportConsularRegistry();
    $pdf->AddPage();
    $pdf->Ln(3);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,utf8_decode('REGISTRO CONSULAR'), 0,1,'C', false);

    $pdf->Ln(3);
    $pdf->SetFillColor(222, 216, 216);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(95,7,utf8_decode('NOMBRES'), 1,0,'C',true);
    $pdf->Cell(0,7,utf8_decode('APELLIDOS'), 1,1,'C',true);
    $pdf->SetFont('Arial','',14);
    $pdf->Cell(95,10,utf8_decode($personalFile->firstName), 1,0,'C',false);
    $pdf->Cell(0,10,utf8_decode($personalFile->lastName), 1,1,'C',false);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(155,7,utf8_decode('LUGAR Y FECHA DE NACIMIENTO'), 1,0,'C',true);
    $pdf->Cell(0,7,utf8_decode('ESTADO CIVIL'), 1,1,'C',true);
    $pdf->SetFont('Arial','',12);
    $Y = $pdf->GetY();
    $pdf->Cell(40,9,utf8_decode($personalFile->birthCountry->countryName),
      'RL',0,'C',false);
    $pdf->Cell(40,9,utf8_decode($personalFile->birthState->stateName), 'RL',
      0,'C',false);
    $pdf->Cell(40,9,utf8_decode($personalFile->birthPlace), 'RL',0,'C',false);
    $pdf->Cell(10,9,utf8_decode($personalFile->parseCarbonDate('birthDate')
      ->day), 'RL',0,'C',false);
    $pdf->Cell(10,9,utf8_decode($personalFile->parseCarbonDate('birthDate')
      ->month), 'RL',0,'C',false);
    $pdf->Cell(15,9,utf8_decode($personalFile->parseCarbonDate('birthDate')
      ->year), 'RL',0,'C',false);
    $pdf->Cell(0,14,utf8_decode($personalFile->civilStateName() ), 'RL',1,
      'C',false);

    $pdf->SetFont('Arial','',10);
    $pdf->SetY($Y+9);
    $pdf->Cell(40,5,utf8_decode('País'), 'RLB',0,'C',false);
    $pdf->Cell(40,5,utf8_decode('Estado/Prov'), 'RLB',0,'C',false);
    $pdf->Cell(40,5,utf8_decode('Ciudad'), 'RLB',0,'C',false);
    $pdf->Cell(10,5,utf8_decode('Dia'), 'RLB',0,'C',false);
    $pdf->Cell(10,5,utf8_decode('Mes'), 'RLB',0,'C',false);
    $pdf->Cell(15,5,utf8_decode('Año'), 'RLB',0,'C',false);

    $X = $pdf->GetX();
    $Y = $pdf->GetY();
    $pdf->SetXY($X, $Y+4);
    $pdf->Cell(0,1,utf8_decode('' ), 'RLB',1,'C',false);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(60,7,utf8_decode('ESTATUS'), 1,0,'C',true);
    $pdf->Cell(45,7,utf8_decode('GACETA'), 1,0,'C',true);
    $pdf->Cell(30,7,utf8_decode('CEDULA'), 1,0,'C',true);
    $pdf->Cell(30,7,utf8_decode('PASAPORTE'), 1,0,'C',true);
    $pdf->Cell(0,7,utf8_decode('DNI'), 1,1,'C',true);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(60,9,utf8_decode('Venezolano').' '.utf8_decode('Naturalizado'),
      'RLB',0,'L',false);
    $pdf->Cell(45,9,utf8_decode('Fecha - Número'), 'LB',
      0,'C',false);
    $pdf->Cell(30,9,utf8_decode($personalFile->personalID), 'RLB',0,'C',false);
    $pdf->Cell(30,9,utf8_decode($personalFile->passportNumber), 'RLB',0,'C',false);
    $pdf->Cell(0,9,utf8_decode($foreignFile->personalID), 'RLB',1,'C',false);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(60,7,utf8_decode('NIVEL ACADEMICO'), 1,0,'C',true);
    $pdf->Cell(60,7,utf8_decode('SITUACIÓN MIGRATORIA '), 1,0,'C',true);
    $pdf->Cell(0,7,utf8_decode('OCUPACIÓN / OFICIO'), 1,1,'C',true);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(60,9,utf8_decode($personalFile->instruccionDegreeName()),1,
      0, 'L', false);
    $pdf->Cell(60,9,utf8_decode($foreignFile->descriptionImmSit->description),
     1,0,'C',false);
    $pdf->Cell(0,9,utf8_decode($personalFile->jobOcupattion), 1,1,'C',false);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(80,7,utf8_decode('TELÉFONOS'), 1,0,'C',true);
    $pdf->Cell(70,7,utf8_decode('CORREO ELECTRÓNICO'), 1,0,'C',true);
    $pdf->Cell(0,7,utf8_decode('TIPO DE SANGRE'), 1,1,'C',true);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(80,9,utf8_decode($foreignFile->mobilePhoneNumber .' '.
      $foreignFile->localPhoneNumber),1, 0, 'L', false);
    $pdf->Cell(70,9,utf8_decode($personalFile->principalEmail), 1,0,'C',false);
    $pdf->Cell(0,9,utf8_decode($personalFile->bloodType), 1,1,'C',false);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,7,utf8_decode('DIRECCIÓN EN ARGENTINA'), 1,1,'C',true);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(50,9,utf8_decode($foreignFile->addressState->stateName), 'RL',
      0, 'L', false);
    $pdf->Cell(100,9,utf8_decode($foreignFile->addressForeign), 'RL',0,'C',
      false);
    $pdf->Cell(0,9,utf8_decode($foreignFile->parseCarbonDate('dateIn')
      ->format('d-m-Y')), 'RL',1,'C',false);
    $pdf->Cell(50,5,utf8_decode('Provincia'), 'RLB',0,'C',false);
    $pdf->Cell(100,5,utf8_decode('Dirección'), 'RLB',0,'C',false);
    $pdf->Cell(0,5,utf8_decode('Ingreso primera vez'), 'RLB',1,'C',false);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,7,utf8_decode('DIRECCIÓN EN VENEZUELA'), 1,1,'C',true);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(50,9,utf8_decode($personalFile->birthState->stateName), 'RL',
      0, 'L', false);
    $pdf->Cell(100,9,utf8_decode($personalFile->addressOrigin), 'RL',0,'C',
      false);
    $pdf->Cell(0,9,utf8_decode($personalFile->localPhoneNumber), 'RL',1,'C',false);
    $pdf->Cell(50,5,utf8_decode('Provincia'), 'RLB',0,'C',false);
    $pdf->Cell(100,5,utf8_decode('Dirección'), 'RLB',0,'C',false);
    $pdf->Cell(0,5,utf8_decode('Teléfono'), 'RLB',1,'C',false);

    $pdf->Ln(5);
    $pdf->Requeriments();
    $pdf->Signatures();




    $pdf->Output('RegistroConsular','I');


  }
}
