<?php

require_once "../server/seguranca.php";
require_once "fpdf/fpdf.php";
$den        = $_GET['den'];
$tipo       = $_GET['tipo'];

$status     = $_GET['status'];

$data       = $_GET['data'];
$dt_ini     = $_GET['dt_ini'];
$dt_fim     = $_GET['dt_fim'];

$emp_id     = $_SESSION['imunevacinas']['usuarioEmpresa'];



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
        //$this->Image('../assets/img/kraft.png',8,1,4);
        // Arial bold 15

    }
    function Footer()
    {
        //Vai para 1.5 cm da borda inferior
        $this->SetY(-7);
        //Seleciona Arial it�lico 8
        $this->SetFont('Arial','I',8);
        //Imprime o n�mero da p�gina centralizado
        $this->Cell(0,11,'P�gina '.$this->PageNo(),0,0,'C');
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
    if($status == 999){
        $query = "select consulta.status, consulta.dt_start as data,usuarios.id as dentista_id, usuarios.especial, usuarios.nome as dentista, consulta.obs as obs, mid(consulta.dt_start,11,6) as dt_start, consulta.ficha as ficha, consulta.cli_nome as cli_nome, consulta.cli_id, cliente.id, cliente.telefone as telefone, cliente.celular as celular, cliente.celular2 as celular2 from usuarios, consulta, cliente where consulta.den_id = '$den_id' and consulta.cli_id = cliente.id and usuarios.id = consulta.den_id and consulta.dt_start BETWEEN '$dt_ini' and '$dt_fim' and consulta.emp_id = '$emp_id' order by consulta.status, consulta.dt_start";

    }else{
        $query = "select consulta.status, consulta.dt_start as data, usuarios.id as dentista_id, usuarios.especial, usuarios.nome as dentista, consulta.obs as obs, mid(consulta.dt_start,11,6) as dt_start, consulta.ficha as ficha, consulta.cli_nome as cli_nome, consulta.cli_id, cliente.id, cliente.telefone as telefone, cliente.celular as celular, cliente.celular2 as celular2 from usuarios, consulta, cliente where consulta.den_id = '$den_id' and consulta.cli_id = cliente.id and usuarios.id = consulta.den_id and consulta.dt_start BETWEEN '$dt_ini' and '$dt_fim' and .consulta.status = '$status' and consulta.emp_id = '$emp_id' order by consulta.status, consulta.dt_start";

    }
    $valida = mysqli_query($con,$query);
    if(mysqli_num_rows($valida) >= 1){
        $pdf->AddPage();
        $pdf -> SetFont('Arial','I','11');
        $pdf -> Cell(9,1,"DR. ".$dentista,0,0,'L');
        $pdf -> Cell(10,1,"DATA: ".$data,0,1,'R');

// Define a Fonte do T�tulo
        $pdf -> SetFont('Arial','B','15');
        $pdf -> Cell(19,1,'RELAT�RIO DE CONSULTAS',0,1,'C');
        $st = 0;
        while($row = mysqli_fetch_array($valida)){
            $horario        = $row['dt_start'];
            $dtt            = substr(substr($row['data'],0,10),8,2)."/".substr(substr($row['data'],0,10),5,2)."/".substr(substr($row['data'],0,10),0,4);
            $paciente       = explode(" ",$row['cli_nome']);
            $paciente       = @$paciente[0]." ".@$paciente[1]." ".@$paciente[3];
            $ficha          = $row['ficha'];
            $obs            = $row['obs'];
            $telefone       = "(".substr($row['telefone'],0,2).") ".substr($row['telefone'],2,4)."-".substr($row['telefone'],6,4);
            $celular        = "(".substr($row['celular'],0,2).") ".substr($row['celular'],2,5)."-".substr($row['celular'],7,4);
            $celular2       = "(".substr($row['celular2'],0,2).") ".substr($row['celular2'],2,5)."-".substr($row['celular2'],7,4);

            if($row['status'] == 1){
                $st_nome = "AGENDADAS";
            }elseif($row['status'] == 2){
                $st_nome = "CONFIRMADAS";
            }elseif($row['status'] == 3){
                $st_nome = "COMPARECIDAS";
            }elseif($row['status'] == 4){
                $st_nome = "REMARCADAS";
            }elseif($row['status'] == 5){
                $st_nome = "FALTANTES";
            }elseif($row['status'] == 6){
                $st_nome = "ATRASADAS";
            }elseif($row['status'] == 7){
                $st_nome = "ENCAIXADAS";
            }
            if($st == $row['status']){
                $pdf -> SetFont('Arial','','8');
            }else{
                $pdf -> SetFont('Arial','B','15');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf ->Cell(4.5,1,$st_nome,0,1,'L');
                $pdf ->Cell(1,0.5,"",0,1,'C');
                $pdf -> SetFont('Arial','B','8');

//Define Cabe�alho com negrito
                $pdf ->SetTextColor(255,255,255);
                $pdf ->SetFillColor(60,115,60);
                $pdf ->SetDrawColor(10,45,10);
                $pdf ->Cell(2,1,'DATA',1,0,'C',1);
                $pdf ->Cell(1.5,1,'HORARIO',1,0,'C',1);
                $pdf ->Cell(2,1,'FICHA',1,0,'C',1);
                $pdf ->Cell(6.5,1,'PACIENTE',1,0,'C',1);
                $pdf ->Cell(3.5,1,'TELEFONE',1,0,'C',1);
                $pdf ->Cell(3.5,1,'CELULAR',1,1,'C',1);
                $pdf ->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
                $st         = $row['status'];
            };
            $pdf ->Cell(2,0.5,$dtt,1,0,'C');
            $pdf ->Cell(1.5,0.5,$horario,1,0,'C');
            $pdf ->Cell(2,0.5,$ficha,1,0,'C');
            $pdf ->Cell(6.5,0.5,$paciente,1,0,'C');
            $pdf ->Cell(3.5,0.5,$telefone,1,0,'C');
            $pdf ->Cell(3.5,0.5,$celular,1,1,'C');
        }
    }
}




//Remove Negrito
$pdf -> SetFont('Arial','','10');
//$pdf->AutoPrint(false);
$pdf -> Output('RelConsulta'.$dentista.$data.'.pdf','S');

?>