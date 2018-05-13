<?php

namespace App\Models;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;

class ReportConsularRegistry extends Fpdf
{
    public function __construct(){
      parent::__construct('P', 'mm');
      $this->SetAutoPageBreak(true, 15);
      $this->SetLeftMargin(9);
      $this->SetRightMargin(9);
      $this->SetTopMargin(15);
      $this->AliasNbPages();
    }

    public function Header()
    {
        $this->Image( Storage::disk('public')->url('img/cintilloRG.jpg') ,10,5,190,12);
        $this->Ln(5);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        $this->Cell(0,4,utf8_decode('Avenida Luis María Campos 170. Capital Federal (1425). República Argentina. Teléfonos 4129-0800. Fax 4129-0823'),0,1,'C');
        $this->Cell(0,4,utf8_decode('Correo-e: consulado.argentina@mppre.gob.ve . Web: http://argentina.embajada.gob.ve'),0,1,'C');
    }


    public function Requeriments()
    {
      $this->SetFont('Arial','B',12);
      $this->Cell(0,6,utf8_decode('RECAUDOS A PRESENTAR:'),0,1,'L');
      $this->SetFont('Arial','',12);
      //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
      $this->Cell(0,6,
        $this->Image(Storage::disk('public')->url('img/checkbox.jpg')
          , $this->GetX(), $this->GetY(), 5).
        utf8_decode('    DOS (02) Planillas de Registro Consular.'),0,1,'L');
      $this->Cell(0,6,
        $this->Image(Storage::disk('public')->url('img/checkbox.jpg')
          , $this->GetX(), $this->GetY(), 5).
        utf8_decode('    Fotocopia simple de la Cédula de Identidad.'),0,1,'L');
      $this->Cell(0,6,
        $this->Image(Storage::disk('public')->url('img/checkbox.jpg')
          , $this->GetX(), $this->GetY(), 5).
        utf8_decode('    Fotocopia simple del Pasaporte Venezolano.'),0,1,'L');
      $this->Cell(0,6,
        $this->Image(Storage::disk('public')->url('img/checkbox.jpg')
          , $this->GetX(), $this->GetY(), 5).
        utf8_decode('    Fotocopia simple de la Partida de Nacimiento (en caso de ser un menor de edad).'),0,1,'L');
      $this->Cell(0,6,
        $this->Image(Storage::disk('public')->url('img/checkbox.jpg')
          , $this->GetX(), $this->GetY(), 5).
        utf8_decode('    Fotocopia simple de Documento Nacional de Identidad.'),0,1,'L');
      $this->Cell(0,6,
        $this->Image(Storage::disk('public')->url('img/checkbox.jpg')
          , $this->GetX(), $this->GetY(), 5).
        utf8_decode('    Fotocopia simple de la Gaceta Oficial (en caso de ser naturalizado).'),0,1,'L');
      $this->Cell(0,6,
        $this->Image(Storage::disk('public')->url('img/checkbox.jpg')
          , $this->GetX(), $this->GetY(), 5).
        utf8_decode('    Certificado de Domicilio (Original).'),0,1,'L');
    }


    public function Signatures()
    {
        $this->SetFont('Arial','B',12);
        $this->Cell(0,16,utf8_decode(''),0,1,'C');
        //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        $this->Cell(95,6,utf8_decode('FIRMA SOLICITANTE'),0,0,'C');
        $this->Cell(0,6,utf8_decode('FIRMA FUNCIONARIO'),0,1,'C');
        $this->SetFont('Arial','',12);
        $this->Cell(0,6,utf8_decode('Buenos Aires, '),0,1,'C');
        $this->SetFont('Arial','',8);
        $this->Cell(0,4,utf8_decode('DECLARO QUE LOS DATOS QUE ANTECENDEN A ESTA SOLICITUD SON VERÍDICOS Y EXACTOS. ASÍ MISMO EXIMO DE TODA'),0,1,'C');
        $this->Cell(0,4,utf8_decode('RESPONSABILIDAD A LA SECCIÓN CONSULARDE LA EMBAJADA DE LA REPÚBLICA BOLIVARIANA DE VENEZUELA EN LA'),0,1,'C');
        $this->Cell(0,4,utf8_decode('REPÚBLICA ARGENTINA, EN EL CASO QUE LOS DATOS SUMINISTRADOS POR MI NO FUERAN FIDEDIGNOS.'),0,1,'C');
    }
}
