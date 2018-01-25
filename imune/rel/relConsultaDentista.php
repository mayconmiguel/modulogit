<?php

require_once "../server/seguranca.php";
require_once "fpdf/fpdf.php";
$den = $_GET['den'];
$tipo = $_GET['tipo'];


$data = $_GET['data'];


if($den == '999'){
    $query = "select * from usuarios where (usuarios.especial = 2 or usuarios.especial = 3)";
    $valida = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($valida)){
        @$den_id .= $row['id'].'-';
    }
    $den_id = substr($den_id,0,strlen($den_id)-1);
}else{
    $den_id = $den;
}


class PDF_Javascript extends FPDF {

    var $javascript;
    var $n_js;

    function IncludeJS($script) {
        $this->javascript=$script;
    }

    function _putjavascript() {
        $this->_newobj();
        $this->n_js=$this->n;
        $this->_out('<<');
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
        $this->_out('>>');
        $this->_out('endobj');
        $this->_newobj();
        $this->_out('<<');
        $this->_out('/S /JavaScript');
        $this->_out('/JS '.$this->_textstring($this->javascript));
        $this->_out('>>');
        $this->_out('endobj');
    }

    function _putresources() {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog() {
        parent::_putcatalog();
        if (isset($this->javascript)) {
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
        }
    }

    function Header()
    {
        // Logo
        $this->Image('../assets/img/kraft.png',8,1,4);
        // Arial bold 15

    }
    function Footer()
    {
        //Vai para 1.5 cm da borda inferior
        $this->SetY(-7);
        //Seleciona Arial itálico 8
        $this->SetFont('Arial','I',8);
        //Imprime o número da página centralizado
        $this->Cell(0,10,'Página '.$this->PageNo(),0,0,'C');
    }
}

class PDF_AutoPrint extends PDF_Javascript
{
    function AutoPrint($dialog=false)
    {
        //Embed some JavaScript to show the print dialog or start printing immediately
        $param=($dialog ? 'true' : 'false');
        $script="print($param);";
        $this->IncludeJS($script);
    }
}
if($tipo == 1){
    $pdf=new PDF_AutoPrint('P','cm','A4');
}else{
    $pdf=new PDF_AutoPrint('L','cm','A4');
}
$pdf->Open();

$explode = explode("-",$den_id);
for($i =0;$i<count($explode);$i++){
    $den_id = $explode[$i];

    $query = "select * from usuarios where id = $den_id ";
    $valida = mysqli_query($con,$query);
    if($row = mysqli_fetch_array($valida)){
        $dentista = $row['nome'];
    }

    $pdf->AddPage();
    $pdf -> SetFont('Arial','I','11');
    $pdf -> Cell(9,1,"DR. ".$dentista,0,0,'L');
    $pdf -> Cell(10,1,"DATA: ".substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4),0,1,'R');

// Define a Fonte do Título
    $pdf -> SetFont('Arial','B','15');
    $pdf -> Cell(19,3,'RELATÓRIO DE CONSULTAS',0,1,'C');

//Define Fonte do Cabeçalho
    $pdf -> SetFont('Arial','B','9');

//Define Cabeçalho com negrito

    if($tipo == 1){
        $pdf ->Cell(2,1,'HORARIO',1,0,'C');
        $pdf ->Cell(2,1,'FICHA',1,0,'C');
        $pdf ->Cell(6,1,'PACIENTE',1,0,'C');
        $pdf ->Cell(9,1,'OBS',1,1,'C');

    }else{
        $pdf ->Cell(2,1,'HORARIO',1,0,'C');
        $pdf ->Cell(2,1,'FICHA',1,0,'C');
        $pdf ->Cell(6.5,1,'PACIENTE',1,0,'C');
        $pdf ->Cell(8,1,'OBS',1,0,'C');
        $pdf ->Cell(3,1,'TELEFONE',1,0,'C');
        $pdf ->Cell(3,1,'CELULAR',1,0,'C');
        $pdf ->Cell(3,1,'CELULAR2',1,1,'C');
    }


    $pdf -> SetFont('Arial','','8');

    $query = "select usuarios.id as dentista_id, usuarios.especial, usuarios.nome as dentista, consulta.obs as obs, mid(consulta.dt_start,11,6) as dt_start, consulta.ficha as ficha, consulta.cli_nome as cli_nome, consulta.cli_id, cliente.id, cliente.telefone as telefone, cliente.celular as celular, cliente.celular2 as celular2 from usuarios, consulta, cliente where den_id = '$den_id' and consulta.status != 4 and consulta.cli_id = cliente.id and usuarios.id = consulta.den_id and left(dt_start,10) = '$data'  order by dt_start";
    $valida = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($valida)){
        $horario        = $row['dt_start'];
        $paciente       = explode(" ",$row['cli_nome']);
        $paciente       = @$paciente[0]." ".@$paciente[1]." ".@$paciente[3];
        $ficha          = $row['ficha'];
        $obs            = $row['obs'];
        $telefone       = "(".substr($row['telefone'],0,2).") ".substr($row['telefone'],2,4)."-".substr($row['telefone'],6,4);
        $celular        = "(".substr($row['celular'],0,2).") ".substr($row['celular'],2,5)."-".substr($row['celular'],7,4);
        $celular2       = "(".substr($row['celular2'],0,2).") ".substr($row['celular2'],2,5)."-".substr($row['celular2'],7,4);


        if($tipo == 1){
            $pdf ->Cell(2,0.5,$horario,1,0,'C');
            $pdf ->Cell(2,0.5,$ficha,1,0,'C');
            $pdf ->Cell(6,0.5,$paciente,1,0,'C');
            $pdf -> SetFont('Arial','','6');
            $pdf ->Cell(9,0.5,$obs,1,1,'C');
            $pdf -> SetFont('Arial','','8');
        }else{
            $pdf ->Cell(2,0.5,$horario,1,0,'C');
            $pdf ->Cell(2,0.5,$ficha,1,0,'C');
            $pdf ->Cell(6.5,0.5,$paciente,1,0,'C');
            $pdf -> SetFont('Arial','','6');
            $pdf ->Cell(8,0.5,$obs,1,0,'C');
            $pdf -> SetFont('Arial','','8');
            $pdf ->Cell(3,0.5,$telefone,1,0,'C');
            $pdf ->Cell(3,0.5,$celular,1,0,'C');
            $pdf ->Cell(3,0.5,$celular2,1,1,'C');
        }



    }


}




//Remove Negrito
$pdf -> SetFont('Arial','','10');
//$pdf->AutoPrint(false);
$pdf -> Output('RelConsulta'.$dentista.$data.'.pdf','I');

?>