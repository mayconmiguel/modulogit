<?php
require_once "../server/seguranca.php";
require_once "fpdf/fpdf.php";
mysqli_set_charset($con,'utf8');
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
        $this->Image('../img/logo3.png',1,0.5,4);
        $this->SetY(1.7);
        // Arial bold 15
        $this->SetY($this->GetY() - 1);
        $this -> SetFont('Arial','','7');
        $this -> Cell("",1,utf8_decode("GERADO POR: ".$_SESSION['imunevacinas']['usuarioNome'])." - ".date('d/m/y H:i:s'),0,1,'R');

    }
    function Footer()
    {
        //Vai para 1.5 cm da borda inferior
        $this->SetY(-7);
        //Seleciona Arial it?lico 8
        $this->SetFont('Arial','I',8);
        //Imprime o n?mero da p?gina centralizado
        $this->Cell(0,11,utf8_decode('Página ').$this->PageNo(),0,0,'C');
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





$dt_ini = $_GET['dt_agenda']." 00:00:00";
$dt_fim = $_GET['dt_agenda']." 23:59:59";

$data = substr($_GET['dt_agenda'],8,2)."/".substr($_GET['dt_agenda'],5,2)."/".substr($_GET['dt_agenda'],0,4);




$emp_id     = $_SESSION['imunevacinas']['usuarioEmpresa'];
if(isset($_GET['id'])){
    $den_id = $_GET['id'];
}else{
    $query = "select pessoa.nome,agenda.pes_id from agenda,pessoa where agenda.pes_id = pessoa.id and agenda.grp_emp_id = ".$emp_id." order by pessoa.nome";
    $valida = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($valida)){
        @$den_id .= $row['pes_id'].'-';
    }
    $den_id = substr($den_id,0,strlen($den_id)-1);
}
$i = 1;
$a = 0;
$b = 0;
$c = 0;
$explode = explode("-",$den_id);
foreach($explode as $id){

    if($i == 1){
        $pdf=new PDF_AutoPrint('P','cm','A4');
        $pdf->SetTitle(utf8_decode('RELATÓRIO CONSULTAS'));
        $pdf->Open();
    }

    $query = "select mid(consulta.dt_start,12,5) as hora, consulta.ficha2, concat(mid(consulta.dt_start,9,2),'/',mid(consulta.dt_start,6,2),'/',mid(consulta.dt_start,1,4)) as dt_start, consulta.ficha as pasta, pessoa.nome as cliente, pessoa.cpf,consulta.obs, (select concat(agenda.prefixo,' ',pes.nome) from pessoa as pes, agenda, consulta as con where con.id = consulta.id and pes.id = con.den_id and agenda.pes_id = con.den_id limit 1) as profissional from consulta,pessoa where pessoa.id = consulta.cli_id and consulta.dt_start between '".$dt_ini."' and '".$dt_fim."' and consulta.den_id = $id  and (consulta.status = 1 or consulta.status = 2 or consulta.status = 3 or consulta.status = 7) order by consulta.dt_start";
    //echo $query;
    $val = mysqli_query($con,$query);


    while($row=mysqli_fetch_array($val)){

        if(mysqli_num_rows($val) > 0){

            if($b == 0){
                $pdf->AddPage();
                $pdf ->Cell("",1,"",1,1,'C');
                $pdf->SetY($pdf->GetY() - 0.8);
                $pdf -> SetFont('Arial','B','10');
                $pdf -> Cell("",0.6,utf8_decode("RELATÓRIO CONSULTAS - ".utf8_decode(mb_strtoupper($row['profissional']))." - DATA: ").$data,0,1,'C');
                $pdf -> SetFont('Arial','B','10');
                $pdf->SetY($pdf->GetY() +0.2);
                $pdf -> SetFont('Arial','B','9');
                $pdf->SetFillColor(26,96,175);
                $pdf->SetTextColor(245,245,245);
                $pdf ->Cell(2,0.6,utf8_decode("HORARIO"),1,0,'C',1);
                $pdf ->Cell(2,0.6,utf8_decode("PASTA"),1,0,'C',1);
                $pdf ->Cell(2,0.6,utf8_decode("ANTIGO"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("CPF"),1,0,'C',1);
                $pdf ->Cell(9.5,0.6,utf8_decode("PACIENTE"),1,1,'C',1);
            };
            $pdf -> SetFont('Arial','B','7');
            $pdf->SetFillColor(255,255,255);
            $pdf->SetTextColor(0,0,0);
            $pdf ->Cell(2,0.4,utf8_decode($row['hora']),1,0,'C',1);
            $pdf ->Cell(2,0.4,utf8_decode($row['pasta']),1,0,'C',1);
            $pdf ->Cell(2,0.4,utf8_decode($row['ficha2']),1,0,'C',1);

            if(strlen($row['cpf']) == 11){
                $cpf = substr($row['cpf'],0,3).".".substr($row['cpf'],3,3).".".substr($row['cpf'],6,3)."-".substr($row['cpf'],9,2);
            }

            $pdf ->Cell(3.5,0.4,utf8_decode($cpf),1,0,'C',1);
            $cpf = '';
            $pdf ->Cell(9.5,0.4,utf8_decode($row['cliente']),1,1,'C',1);

            $pdf -> SetFont('Arial','I','6');
            $pdf ->Cell(19,0.4,utf8_decode("OBS: ".$row['obs']),1,1,'L',1);

            $a++;
            $b++;
            $c++;
            if($b == mysqli_num_rows($val)){
                $b = 0;
            }
        };


    }

    $i++;


    if(($i == count($explode)+1) && ($a == 0)){
        ?>
        <script>
            alert("Nenhum registro encontrado!");
            window.close();
        </script>
        <?php
    }

}







$pdf -> Output('Financeiro'.date("d-m-Y").'.pdf','I');


?>