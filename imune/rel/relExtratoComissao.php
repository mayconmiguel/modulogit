<?php
require_once "../server/seguranca.php";
require_once "fpdf/fpdf.php";



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



$pdf=new PDF_AutoPrint('P','cm','A4');
$pdf->SetTitle(utf8_decode('RELATÓRIO DE COMISSÃO - FFSEGUROS'));
$pdf->Open();


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $_SESSION['imunevacinas']['seguradora']     = $_POST['seguradora'];
    $_SESSION['imunevacinas']['tipo']           = $_POST['tipo'];

    $_SESSION['imunevacinas']['relEmpresa']     = $_POST['empresa'];
    $_SESSION['imunevacinas']['dt_ini']         = substr($_POST['from'],6,4)."-".substr($_POST['from'],3,2)."-".substr($_POST['from'],0,2)." 00:00:00";
    $_SESSION['imunevacinas']['dt_fim']         = substr($_POST['to'],6,4)."-".substr($_POST['to'],3,2)."-".substr($_POST['to'],0,2)." 23:59:59";
}
    $query      = "select extrato.id,financeiro.id as fin, extrato.obs, concat(banco.cod,'-',banco.banco) as banco, pagamento.nome as pagamento,financeiro.dt_baixa,extrato.numero, empresa.razao as empresa, pessoa.nome as seguradora, extrato.dt_cad, extrato.pr_bruto, extrato.iss, extrato.irrf, extrato.ntributado, extrato.pr_liquido, extrato.img_fiscal,extrato.pdf_fiscal, financeiro.status  from  pagamento,banco,empresa, pessoa, extrato, financeiro where extrato.pag_id = pagamento.id and extrato.ban_id = banco.id and extrato.emp_id = empresa.id and extrato.seg_id = pessoa.id and financeiro.ex_id = extrato.id and extrato.dt_cad between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."'";

if($_SESSION['imunevacinas']['seguradora'][0]== 999){

}else{
    $query .= " and (";
    foreach ($_SESSION['imunevacinas']['seguradora'] as $selectedOption){
        $query .= " extrato.seg_id = '".$selectedOption."' or ";
    }
    $query = substr($query,0,strlen($query)-3);
    $query .= ") ";
};

if($_SESSION['imunevacinas']['relEmpresa'][0]== 999){

}else{
    $query .= " and (";
    foreach ($_SESSION['imunevacinas']['relEmpresa'] as $selectedOption){
        $query .= " extrato.emp_id = '".$selectedOption."' or ";
    }
    $query = substr($query,0,strlen($query)-3);
    $query .= ") ";
};


if($_SESSION['imunevacinas']['tipo'] == 1){
    $query .= " and financeiro.status = 2 ";
}
else if($_SESSION['imunevacinas']['tipo'] == 2){
    $query .= " and financeiro.status = 4 ";
}

$query .= ' order by empresa asc, seguradora asc, extrato.dt_cad asc';



$i                  = 0;
$s                  = 0;
$empresa            = "";
$seguradora         = "";
$totalseguradora    = 0;
$issseguradora      = 0;
$irrfseguradora     = 0;
$ntribseguradora    = 0;
$totalempresa       = 0;
$issempresa         = 0;
$irrfempresa        = 0;
$ntribempresa       = 0;
$isstotal           = 0;
$irrftotal          = 0;
$ntribtotal         = 0;
$geralbruto         = 0;
$geraliss           = 0;
$geralirrf          = 0;
$geralntrib         = 0;
$geralliquido       = 0;
$brutoseguradora    = 0;
$brutoempresa       = 0;

if($valida = mysqli_query($con,$query)){
    while($row = mysqli_fetch_array($valida)){
        if($i == 0){
            $pdf->AddPage();
            $pdf -> SetFont('Arial','I','11');
            $pdf -> Cell("",1,utf8_decode("RELATÓRIO  - LANÇAMENTO EXTRATO DE COMISSÃO  -  PERÍODO: ".substr($_SESSION['imunevacinas']['dt_ini'],8,2)."/".substr($_SESSION['imunevacinas']['dt_ini'],5,2)."/".substr($_SESSION['imunevacinas']['dt_ini'],0,4)." À ".substr($_SESSION['imunevacinas']['dt_fim'],8,2)."/".substr($_SESSION['imunevacinas']['dt_fim'],5,2)."/".substr($_SESSION['imunevacinas']['dt_fim'],0,4)),1,1,'C');
            $pdf -> SetFont('Arial','B','10');
        }else{

        };

        if($empresa != $row['empresa']){
            if($i == 0){

            }else{
                $pdf -> SetFont('Arial','B','8');
                $pdf ->Cell("",1,"",1,1,'C');
                $pdf ->SetY($pdf->GetY() - 0.8);
                $pdf ->Cell(5.5,0.6,"SUBTOTAL SEGURADORA:",0,0,'C');
                $pdf -> SetFont('Arial','','8');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($brutoseguradora,2,",","."),0,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($issseguradora,2,",","."),0,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($irrfseguradora,2,",","."),0,0,'C');
                $pdf ->Cell(2.5,0.6,"R$ ".number_format($ntribseguradora,2,",","."),0,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($totalseguradora,2,",","."),0,1,'C');
                $pdf ->SetY($pdf->GetY() + 0.2);

                $pdf -> SetFont('Arial','B','9');
                $pdf ->Cell("",1,"",1,1,'C');
                $pdf ->SetY($pdf->GetY() - 0.8);
                $pdf ->Cell(5.5,0.6,"SUBTOTAL EMPRESA:",0,0,'C');
                $pdf -> SetFont('Arial','','9');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($brutoempresa,2,",","."),0,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($issempresa,2,",","."),0,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($irrfempresa,2,",","."),0,0,'C');
                $pdf ->Cell(2.5,0.6,"R$ ".number_format($ntribempresa,2,",","."),0,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($totalempresa,2,",","."),0,1,'C');
                $pdf ->SetY($pdf->GetY() + 0.2);
                $pdf->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');

                $totalseguradora    = 0;
                $brutoseguradora    = 0;
                $totalempresa       = 0;
                $brutoempresa       = 0;
                $issseguradora      = 0;
                $irrfseguradora     = 0;
                $ntribseguradora    = 0;
                $issempresa         = 0;
                $irrfempresa        = 0;
                $ntribempresa       = 0;
            };
            $pdf -> SetFont('Arial','B','10');
            $pdf ->Cell("",0.5,"",0,1,'L');
            $pdf ->Cell("",0.7,"   EMPRESA: ".utf8_decode($row['empresa']),1,1,'L');

            if($seguradora != $row['seguradora']){
                if($s == 0){

                }else{

                };
                $pdf -> SetFont('Arial','B','9');
                $pdf ->Cell("",0.7,"   SEGURADORA: ".utf8_decode($row['seguradora']),1,1,'L');
                $pdf -> SetFont('Arial','B','8');
                $pdf->SetFillColor(26,96,175);
                $pdf->SetTextColor(245,245,245);
                $pdf ->Cell(2,0.6,utf8_decode("DATA"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("Nº EXTRATO"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,"VALOR BRUTO",1,0,'C',1);
                $pdf ->Cell(2,0.6,"I.S.S",1,0,'C',1);
                $pdf ->Cell(2,0.6,"I.R.R.F",1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("Ñ TRIB."),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("VALOR LÍQUIDO"),1,1,'C',1);
                $pdf -> SetFont('Arial','','8');
                $pdf->SetTextColor(0,0,0);
                $pdf ->Cell(2,0.6,substr($row['dt_cad'],8,2)."/".substr($row['dt_cad'],5,2)."/".substr($row['dt_cad'],0,4),1,0,'C');
                $pdf ->Cell(3.5,0.6,$row['numero'],1,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($row['pr_bruto'],2,",","."),1,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($row['iss'],2,",","."),1,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($row['irrf'],2,",","."),1,0,'C');
                $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['ntributado'],2,",","."),1,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($row['pr_liquido'],2,",","."),1,1,'C');
                $pdf -> SetFont('Arial','B','8');
                $pdf->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');

                $seguradora = $row['seguradora'];
            }else{
                $pdf -> SetFont('Arial','','8');
                $pdf->SetTextColor(0,0,0);
                $pdf ->Cell(2,0.6,substr($row['dt_cad'],8,2)."/".substr($row['dt_cad'],5,2)."/".substr($row['dt_cad'],0,4),1,0,'C');
                $pdf ->Cell(3.5,0.6,$row['numero'],1,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($row['pr_bruto'],2,",","."),1,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($row['iss'],2,",","."),1,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($row['irrf'],2,",","."),1,0,'C');
                $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['ntributado'],2,",","."),1,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($row['pr_liquido'],2,",","."),1,1,'C');
                $pdf->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
            }
            $s++;
            $empresa = $row['empresa'];
        }else{
            if($seguradora != $row['seguradora']){
                if($s == 0){

                }else{
                    $pdf -> SetFont('Arial','B','8');
                    $pdf ->Cell("",1,"",1,1,'C');
                    $pdf ->SetY($pdf->GetY() - 0.8);
                    $pdf ->Cell(5.5,0.6,"SUBTOTAL SEGURADORA:",0,0,'C');
                    $pdf -> SetFont('Arial','','8');
                    $pdf ->Cell(3.5,0.6,"R$ ".number_format($brutoseguradora,2,",","."),0,0,'C');
                    $pdf ->Cell(2,0.6,"R$ ".number_format($issseguradora,2,",","."),0,0,'C');
                    $pdf ->Cell(2,0.6,"R$ ".number_format($irrfseguradora,2,",","."),0,0,'C');
                    $pdf ->Cell(2.5,0.6,"R$ ".number_format($ntribseguradora,2,",","."),0,0,'C');
                    $pdf ->Cell(3.5,0.6,"R$ ".number_format($totalseguradora,2,",","."),0,1,'C');
                    $pdf ->SetY($pdf->GetY() + 0.2);
                    $totalseguradora    = 0;
                    $issseguradora      = 0;
                    $irrfseguradora     = 0;
                    $ntribseguradora    = 0;
                    $brutoseguradora    = 0;
                };
                $pdf -> SetFont('Arial','B','9');
                $pdf ->Cell("",0.7,"   SEGURADORA: ".utf8_decode($row['seguradora']),1,1,'L');
                $pdf -> SetFont('Arial','B','8');
                $pdf->SetFillColor(26,96,175);
                $pdf->SetTextColor(245,245,245);
                $pdf ->Cell(2,0.6,utf8_decode("DATA"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("Nº EXTRATO"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,"VALOR BRUTO",1,0,'C',1);
                $pdf ->Cell(2,0.6,"I.S.S",1,0,'C',1);
                $pdf ->Cell(2,0.6,"I.R.R.F",1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("Ñ TRIB."),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("VALOR LÍQUIDO"),1,1,'C',1);
                $pdf -> SetFont('Arial','','8');
                $pdf->SetTextColor(0,0,0);
                $pdf ->Cell(2,0.6,substr($row['dt_cad'],8,2)."/".substr($row['dt_cad'],5,2)."/".substr($row['dt_cad'],0,4),1,0,'C');
                $pdf ->Cell(3.5,0.6,$row['numero'],1,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($row['pr_bruto'],2,",","."),1,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($row['iss'],2,",","."),1,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($row['irrf'],2,",","."),1,0,'C');
                $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['ntributado'],2,",","."),1,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($row['pr_liquido'],2,",","."),1,1,'C');
                $pdf->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
                $seguradora = $row['seguradora'];
            }else{
                $pdf -> SetFont('Arial','','8');
                $pdf->SetTextColor(0,0,0);
                $pdf ->Cell(2,0.6,substr($row['dt_cad'],8,2)."/".substr($row['dt_cad'],5,2)."/".substr($row['dt_cad'],0,4),1,0,'C');
                $pdf ->Cell(3.5,0.6,$row['numero'],1,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($row['pr_bruto'],2,",","."),1,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($row['iss'],2,",","."),1,0,'C');
                $pdf ->Cell(2,0.6,"R$ ".number_format($row['irrf'],2,",","."),1,0,'C');
                $pdf ->Cell(2.5,0.6,"R$ ".number_format($row['ntributado'],2,",","."),1,0,'C');
                $pdf ->Cell(3.5,0.6,"R$ ".number_format($row['pr_liquido'],2,",","."),1,1,'C');
                $pdf->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
            }
            $s++;
        }
        $totalseguradora    += $row['pr_liquido'];
        $totalempresa       += $row['pr_liquido'];
        $brutoempresa       += $row['pr_bruto'];
        $brutoseguradora    += $row['pr_bruto'];
        $issseguradora      += $row['iss'];
        $issempresa         += $row['iss'];
        $irrfseguradora     += $row['irrf'];
        $irrfempresa        += $row['irrf'];
        $ntribseguradora    += $row['ntributado'];
        $ntribempresa       += $row['ntributado'];
        $geralbruto         += $row['pr_bruto'];
        $geraliss           += $row['iss'];
        $geralirrf          += $row['irrf'];
        $geralntrib         += $row['ntributado'];
        $geralliquido       += $row['pr_liquido'];
        if($i+1 == mysqli_num_rows($valida)){
            $pdf -> SetFont('Arial','B','7');
            $pdf ->Cell("",1,"",1,1,'C');
            $pdf ->SetY($pdf->GetY() - 0.8);
            $pdf ->Cell(5.5,0.6,"SUBTOTAL SEGURADORA:",0,0,'C');
            $pdf -> SetFont('Arial','','8');
            $pdf ->Cell(3.5,0.6,"R$ ".number_format($brutoseguradora,2,",","."),0,0,'C');
            $pdf ->Cell(2,0.6,"R$ ".number_format($issseguradora,2,",","."),0,0,'C');
            $pdf ->Cell(2,0.6,"R$ ".number_format($irrfseguradora,2,",","."),0,0,'C');
            $pdf ->Cell(2.5,0.6,"R$ ".number_format($ntribseguradora,2,",","."),0,0,'C');
            $pdf ->Cell(3.5,0.6,"R$ ".number_format($totalseguradora,2,",","."),0,1,'C');
            $pdf ->SetY($pdf->GetY() + 0.2);

            $pdf -> SetFont('Arial','B','8');
            $pdf ->Cell("",1,"",1,1,'C');
            $pdf ->SetY($pdf->GetY() - 0.8);
            $pdf ->Cell(5.5,0.6,"SUBTOTAL EMPRESA:",0,0,'C');
            $pdf -> SetFont('Arial','','9');
            $pdf ->Cell(3.5,0.6,"R$ ".number_format($brutoempresa,2,",","."),0,0,'C');
            $pdf ->Cell(2,0.6,"R$ ".number_format($issempresa,2,",","."),0,0,'C');
            $pdf ->Cell(2,0.6,"R$ ".number_format($irrfempresa,2,",","."),0,0,'C');
            $pdf ->Cell(2.5,0.6,"R$ ".number_format($ntribempresa,2,",","."),0,0,'C');
            $pdf ->Cell(3.5,0.6,"R$ ".number_format($totalempresa,2,",","."),0,1,'C');
            $pdf ->SetY($pdf->GetY() + 0.2);
            $totalseguradora    = 0;
            $totalempresa       = 0;
            $issseguradora      = 0;
            $irrfseguradora     = 0;
            $ntribseguradora    = 0;
            $issempresa         = 0;
            $irrfempresa        = 0;
            $ntribempresa       = 0;
            $brutoempresa       = 0;
            $brutoseguradora    = 0;
        }
        $i++;
    };
    $pdf -> SetFont('Arial','B','9');
    $pdf ->Cell("",1,"",0,1,'C');
    $pdf ->Cell("",1,"",1,1,'C');
    $pdf ->SetY($pdf->GetY() - 0.8);
    $pdf ->Cell(5.5,0.6,"TOTAL GERAL:",0,0,'C');
    $pdf ->Cell(3.5,0.6,"R$ ".number_format($geralbruto,2,",","."),0,0,'C');
    $pdf ->Cell(2,0.6,"R$ ".number_format($geraliss,2,",","."),0,0,'C');
    $pdf ->Cell(2,0.6,"R$ ".number_format($geralirrf,2,",","."),0,0,'C');
    $pdf ->Cell(2.5,0.6,"R$ ".number_format($geralntrib,2,",","."),0,0,'C');
    $pdf ->Cell(3.5,0.6,"R$ ".number_format($geralliquido,2,",","."),0,1,'C');
    $pdf ->SetY($pdf->GetY() + 0.2);

}


$pdf -> Output('ExtratoComissao'.date("d-m-Y").'.pdf','I');

?>