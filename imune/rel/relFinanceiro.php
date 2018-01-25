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


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_SESSION['imunevacinas']['relTipo']        = @$_POST['tipo'];
    $_SESSION['imunevacinas']['relFrom']        = @$_POST['from'];
    $_SESSION['imunevacinas']['relTo']          = @$_POST['to'];
    $_SESSION['imunevacinas']['relPessoa']      = @$_POST['retorno'];
    $_SESSION['imunevacinas']['relEmpresa']     = @$_POST['empresa'];
    $_SESSION['imunevacinas']['relBanco']       = @$_POST['banco'];
    $_SESSION['imunevacinas']['relCentroCusto'] = @$_POST['centrocusto'];
    $_SESSION['imunevacinas']['relNatureza']    = @$_POST['natureza'];
    $_SESSION['imunevacinas']['relPagamento']   = @$_POST['pagamento'];
    $_SESSION['imunevacinas']['relGroup']       = @$_POST['group'];
    $_SESSION['imunevacinas']['dt_ini']         = substr($_SESSION['imunevacinas']['relFrom'],6,4)."-".substr($_SESSION['imunevacinas']['relFrom'],3,2)."-".substr($_SESSION['imunevacinas']['relFrom'],0,2)." 00:00:00";
    $_SESSION['imunevacinas']['dt_fim']       = substr($_SESSION['imunevacinas']['relTo'],6,4)."-".substr($_SESSION['imunevacinas']['relTo'],3,2)."-".substr($_SESSION['imunevacinas']['relTo'],0,2)." 23:59:59";
    $i              = 0;
    $query = "select f.id,f.dt_emi,mid(f.dt_fat,1,10) as dt_fat,mid(f.dt_baixa,1,10) as dt_baixa,f.qtd,f.parcela,concat(f.boleto,'',f.cheque) as numero,f.valorbruto,f.jurosper,f.jurosreal,f.descper,f.descreal,f.valorliquido,f.obs,concat(banco.cod,'-',banco.banco) as banco, empresa.razao as empresa, pessoa.nome as pessoa, centrocusto.nome as centrocusto, natureza.nome as natureza, pagamento.nome as pagamento from financeiro as f, empresa, pessoa,banco,pagamento,centrocusto,natureza where f.grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." and   f.pes_id = pessoa.id and f.emp_id = empresa.id and f.ban_id = banco.id and f.cen_id = centrocusto.id and f.nat_id = natureza.id and f.pag_id = pagamento.id and f.status = ".$_SESSION['imunevacinas']['relTipo']." ";

    if($_SESSION['imunevacinas']['relTipo'] == 1){
        $_SESSION['imunevacinas']['relTP'] = "À PAGAR";
        $query .= " and f.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' ";
    }
    else if($_SESSION['imunevacinas']['relTipo'] == 2){
        $_SESSION['imunevacinas']['relTP'] = "À RECEBER";
        $query .= " and f.dt_fat between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' ";
    }
    else if($_SESSION['imunevacinas']['relTipo'] == 3){
        $_SESSION['imunevacinas']['relTP'] = "PAGAS";
        $query .= " and f.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' ";
    }
    else if($_SESSION['imunevacinas']['relTipo'] == 4){
        $_SESSION['imunevacinas']['relTP'] = "RECEBIDAS";
        $query .= " and f.dt_baixa between '".$_SESSION['imunevacinas']['dt_ini']."' and '".$_SESSION['imunevacinas']['dt_fim']."' ";
    }

}

//totalizadores

$brutoTotal = $jurosTotal = $descTotal = $liquidoTotal = 0;
$brutoCampo = $jurosCampo = $descCampo = $liquidoCampo = 0;


$pdf=new PDF_AutoPrint('L','cm','A4');
$pdf->SetTitle(utf8_decode('RELATÓRIO FINANCEIRO - CONTAS '.$_SESSION['imunevacinas']['relTP']));
$pdf->Open();
if($_SESSION['imunevacinas']['relPessoa'] != ""){
    $pessoa = $_SESSION['imunevacinas']['relPessoa'];
    $query .= "and pes_id = " .$_SESSION['imunevacinas']['relPessoa']." ";
};
if(isset($_SESSION['imunevacinas']['relEmpresa'])){
    $empresa = $_SESSION['imunevacinas']['relEmpresa'];
    $query .= "and (";
    foreach($empresa as $emp){
        $query .= " f.emp_id = $emp or ";
    };
    $query = substr($query,0,strlen($query) -3);
    $query .= ") ";
};
if(isset($_SESSION['imunevacinas']['relBanco'])){
    $banco = $_SESSION['imunevacinas']['relBanco'];
    $query .= "and (";
    foreach($banco as $ban){
        $query .= " f.ban_id = $ban or ";
    };
    $query = substr($query,0,strlen($query) -3);
    $query .= ") ";
};

if(isset($_SESSION['imunevacinas']['relCentroCusto'])){
    $centrocusto = $_SESSION['imunevacinas']['relCentroCusto'];
    $query .= "and (";
    foreach($centrocusto as $cen){
        $query .= " f.cen_id = $cen or ";
    };
    $query = substr($query,0,strlen($query) -3);
    $query .= ") ";
};

if(isset($_SESSION['imunevacinas']['relNatureza'])){
    $natureza = $_SESSION['imunevacinas']['relNatureza'];
    $query .= "and (";
    foreach($natureza as $nat){
        $query .= " f.nat_id = $nat or ";
    };
    $query = substr($query,0,strlen($query) -3);
    $query .= ") ";
};

if(isset($_SESSION['imunevacinas']['relPagamento'])){
    $pagamento = $_SESSION['imunevacinas']['relPagamento'];
    $query .= "and (";
    foreach($pagamento as $pag){
        $query .= " f.pag_id = $pag or ";
    };
    $query = substr($query,0,strlen($query) -3);
    $query .= ") ";
};

if($_SESSION['imunevacinas']['relGroup'] == 1){
    if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
        $query .= " order by f.dt_fat asc, f.dt_cad";
        $titulo = "DATA";
        $campo  = 'dt_fat';
    }else{
        $query .= " order by f.dt_baixa asc, f.dt_cad";
        $titulo = "DATA";
        $campo  = 'dt_baixa';
    }
}
else if($_SESSION['imunevacinas']['relGroup'] == 2){
    $query .= " order by empresa asc, f.dt_cad";
    $titulo = "EMPRESA";
    $campo  = 'empresa';
}
else if($_SESSION['imunevacinas']['relGroup'] == 3){
    $query .= " order by banco asc, f.dt_cad";
    $titulo = "BANCO";
    $campo  = 'banco';
}
else if($_SESSION['imunevacinas']['relGroup'] == 4){
    $query .= " order by centrocusto asc, f.dt_cad";
    $titulo = "CENTRO DE CUSTO";
    $campo  = 'centrocusto';
}
else if($_SESSION['imunevacinas']['relGroup'] == 5){
    $query .= " order by natureza asc, f.dt_cad";
    $titulo = "NATUREZA FINANCEIRA";
    $campo  = 'natureza';
}
else if($_SESSION['imunevacinas']['relGroup'] == 6) {
    $query .= " order by pagamento asc, f.dt_cad";
    $titulo = "FORMA DE PAGAMENTO";
    $campo  = 'pagamento';
}
else if($_SESSION['imunevacinas']['relGroup'] == 7){
    $query .= " order by pessoa asc, f.dt_cad";
    $titulo = "NOME";
    $campo  = 'pessoa';
}


$i = 0;
$ordenador = "";

$valida = mysqli_query($con,$query);
if(mysqli_num_rows($valida) > 0){
    while($row = mysqli_fetch_array($valida)){
        if($row['jurosper'] == 0){
            $juros = $row['jurosreal'];
        }else{
            $juros = ($row['jurosper']*100) / $row['valorbruto'];
        };

        if(@$row['descper'] == 0){
            $desc = $row['descreal'];
        }else{
            $desc = ($row['descper']*100) / $row['valorbruto'];
        };
        if($i == 0){
            $pdf->AddPage();
            $pdf ->Cell("",1,"",1,1,'L');
            $pdf->SetY($pdf->GetY() - 0.8);
            $pdf -> SetFont('Arial','I','12');
            $pdf -> Cell("",0.6,utf8_decode("RELATÓRIO FINANCEIRO - CONTAS ".$_SESSION['imunevacinas']['relTP']." - PERÍODO: ".$_SESSION['imunevacinas']['relFrom']." À ".$_SESSION['imunevacinas']['relTo']),0,1,'C');
            $pdf -> SetFont('Arial','B','10');
            $pdf -> Cell(0.3,0.6,"",0,0,'L');
        }else{

        };
        if($ordenador != $row[$campo]){
            if($i == 0){

            }else{
                $pdf -> SetFont('Arial','B','8');
                $pdf ->Cell("",1,"",1,1,'C');
                $pdf ->SetY($pdf->GetY() - 0.8);
                $pdf ->Cell(5.5,0.6,"SUBTOTAL ".$titulo.": ",0,0,'C');
                $pdf -> SetFont('Arial','','8');
                $pdf ->Cell(5.5,0.6,"VLR. BRUTO: R$ ".number_format($brutoCampo,2,",","."),0,0,'C');
                $pdf ->Cell(5,0.6,"JUROS: R$ ".number_format($jurosCampo,2,",","."),0,0,'C');
                $pdf ->Cell(5,0.6,"DESCONTO: R$ ".number_format($descCampo,2,",","."),0,0,'C');
                $pdf ->Cell(5.5,0.6,"VLR. LIQUIDO: R$ ".number_format($liquidoCampo,2,",","."),0,0,'C');
                $pdf ->SetY($pdf->GetY() + 0.2);
                $brutoCampo = $jurosCampo = $descCampo = $liquidoCampo = 0;
            }
            $pdf->SetY($pdf->GetY() +1);
            $pdf -> SetFont('Arial','B','10');
            if($campo == 'dt_fat' || $campo == 'dt_baixa'){
                $pdf ->Cell("",0.7,"   ".$titulo.": ".substr($row[$campo],8,2)."/".substr($row[$campo],5,2)."/".substr($row[$campo],0,4),1,1,'L');
            }else{
                $pdf ->Cell("",0.7,"   ".$titulo.": ".$row[$campo],1,1,'L');
            }
            $pdf -> SetFont('Arial','B','7');
            $pdf->SetFillColor(26,96,175);
            $pdf->SetTextColor(245,245,245);
            $pdf ->Cell(2,0.6,utf8_decode("Nº"),1,0,'C',1);
            $pdf ->Cell(1.5,0.6,utf8_decode("DT. EMI."),1,0,'C',1);
            if($campo == 'dt_fat'){
                $pdf ->Cell(3,0.6,utf8_decode("NOME"),1,0,'C',1);
                $pdf ->Cell(3,0.6,utf8_decode("EMPRESA"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("BANCO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("C.CUSTO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("NAT. FIN."),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("F. PAG."),1,0,'C',1);
            }
            else if($campo == 'dt_baixa'){
                $pdf ->Cell(3,0.6,utf8_decode("NOME"),1,0,'C',1);
                $pdf ->Cell(3,0.6,utf8_decode("EMPRESA"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("BANCO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("C.CUSTO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("NAT. FIN."),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("F. PAG."),1,0,'C',1);
            }
            else if($campo == 'pessoa'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. VENC."),1,0,'C',1);
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. BAIXA"),1,0,'C',1);
                }
                $pdf ->Cell(4.5,0.6,utf8_decode("EMPRESA"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("BANCO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("C.CUSTO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("NAT. FIN."),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("F. PAG."),1,0,'C',1);
            }
            else if($campo == 'empresa'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. VENC."),1,0,'C',1);
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. BAIXA"),1,0,'C',1);
                }
                $pdf ->Cell(4.5,0.6,utf8_decode("NOME"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("BANCO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("C.CUSTO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("NAT. FIN."),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("F. PAG."),1,0,'C',1);
            }
            else if($campo == 'banco'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. VENC."),1,0,'C',1);
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. BAIXA"),1,0,'C',1);
                }
                $pdf ->Cell(4.5,0.6,utf8_decode("NOME"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("EMPRESA"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("C.CUSTO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("NAT. FIN."),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("F. PAG."),1,0,'C',1);
            }
            else if($campo == 'centrocusto'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. VENC."),1,0,'C',1);
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. BAIXA"),1,0,'C',1);
                }
                $pdf ->Cell(4.5,0.6,utf8_decode("NOME"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("EMPRESA"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("BANCO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("NAT. FIN."),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("F. PAG."),1,0,'C',1);
            }
            else if($campo == 'natureza'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. VENC."),1,0,'C',1);
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. BAIXA"),1,0,'C',1);
                }
                $pdf ->Cell(4.5,0.6,utf8_decode("NOME"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("EMPRESA"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("BANCO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("C.CUSTO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("F. PAG."),1,0,'C',1);
            }
            else if($campo == 'pagamento'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. VENC."),1,0,'C',1);
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode("DT. BAIXA"),1,0,'C',1);
                }
                $pdf ->Cell(4.5,0.6,utf8_decode("NOME"),1,0,'C',1);
                $pdf ->Cell(3.5,0.6,utf8_decode("EMPRESA"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("BANCO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("C.CUSTO"),1,0,'C',1);
                $pdf ->Cell(2.5,0.6,utf8_decode("NAT. FIN."),1,0,'C',1);
            }
            $pdf ->Cell(1.6,0.6,"T.P.",1,0,'C',1);
            $pdf ->Cell(1.8,0.6,"BRUTO",1,0,'C',1);
            $pdf ->Cell(1,0.6,"J.",1,0,'C',1);
            $pdf ->Cell(1,0.6,"D.",1,0,'C',1);
            $pdf ->Cell(1.8,0.6,utf8_decode("LÍQD."),1,1,'C',1);




            //DADOS RECUPERADOS DO BANCO DE DADOS
            $pdf->SetTextColor(0,0,0);
            $pdf -> SetFont('Arial','','6.8');
            $pdf ->Cell(2,0.6,utf8_decode($row['id']),1,0,'C');
            $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4)),1,0,'C');
            if($campo == 'dt_fat'){
                $pdf ->Cell(3,0.6,substr(explode("-",$row['pessoa'])[0],0,19),1,0,'C');
                $pdf ->Cell(3,0.6,substr(explode("-",$row['empresa'])[0],0,19),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['banco'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'dt_baixa'){
                $pdf ->Cell(3,0.6,substr(explode("-",$row['pessoa'])[0],0,19),1,0,'C');
                $pdf ->Cell(3,0.6,substr(explode("-",$row['empresa'])[0],0,19),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['banco'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'pessoa'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['empresa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['banco'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'empresa'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['banco'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'banco'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['empresa'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'centrocusto'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['empresa'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['banco'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'natureza'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['empresa'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['banco'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'pagamento'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['empresa'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['banco'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
            }
            $pdf ->Cell(1.6,0.6,$row['qtd']."/".$row['parcela'],1,0,'C');
            $pdf ->Cell(1.8,0.6,"R$ ".$row['valorbruto'],1,0,'C');
            $pdf ->Cell(1,0.6,number_format($juros,2,",","."),1,0,'C');
            $pdf ->Cell(1,0.6,number_format($desc,2,",","."),1,0,'C');
            $pdf ->Cell(1.8,0.6,"R$ ".number_format($row['valorliquido'],2,',','.'),1,1,'C');

            $ordenador = $row[$campo];
        }else{


            //DADOS RECUPERADOS DO BANCO DE DADOS
            $pdf->SetTextColor(0,0,0);
            $pdf -> SetFont('Arial','','6.8');
            $pdf ->Cell(2,0.6,utf8_decode($row['id']),1,0,'C');
            $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_emi'],8,2)."/".substr($row['dt_emi'],5,2)."/".substr($row['dt_emi'],0,4)),1,0,'C');
            if($campo == 'dt_fat'){
                $pdf ->Cell(3,0.6,substr(explode("-",$row['pessoa'])[0],0,20),1,0,'C');
                $pdf ->Cell(3,0.6,substr(explode("-",$row['empresa'])[0],0,20),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['banco'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'dt_baixa'){
                $pdf ->Cell(3,0.6,substr(explode("-",$row['pessoa'])[0],0,19),1,0,'C');
                $pdf ->Cell(3,0.6,substr(explode("-",$row['empresa'])[0],0,19),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['banco'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'pessoa'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['empresa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['banco'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'empresa'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['banco'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'banco'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['empresa'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'centrocusto'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['empresa'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['banco'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'natureza'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['empresa'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['banco'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['pagamento'],0,14),1,0,'C');
            }
            else if($campo == 'pagamento'){
                if($_SESSION['imunevacinas']['relTipo'] == 1 || $_SESSION['imunevacinas']['relTipo'] == 2){
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4)),1,0,'C');
                }else{
                    $pdf ->Cell(1.5,0.6,utf8_decode(substr($row['dt_baixa'],8,2)."/".substr($row['dt_baixa'],5,2)."/".substr($row['dt_baixa'],0,4)),1,0,'C');
                }
                $pdf ->Cell(4.5,0.6,substr(explode("-",$row['pessoa'])[0],0,29),1,0,'C');
                $pdf ->Cell(3.5,0.6,substr($row['empresa'],0,23).".",1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['banco'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['centrocusto'],0,14),1,0,'C');
                $pdf ->Cell(2.5,0.6,substr($row['natureza'],0,14),1,0,'C');
            }
            $pdf ->Cell(1.6,0.6,$row['qtd']."/".$row['parcela'],1,0,'C');
            $pdf ->Cell(1.8,0.6,"R$ ".$row['valorbruto'],1,0,'C');
            $pdf ->Cell(1,0.6,number_format($juros,2,",","."),1,0,'C');
            $pdf ->Cell(1,0.6,number_format($desc,2,",","."),1,0,'C');
            $pdf ->Cell(1.8,0.6,"R$ ".number_format($row['valorliquido'],2,',','.'),1,1,'C');

        }
        $brutoTotal         += $row['valorbruto'];
        $jurosTotal         += $juros;
        $descTotal          += $desc;
        $liquidoTotal       += $row['valorliquido'];
        $brutoCampo         += $row['valorbruto'];
        $jurosCampo         += $juros;
        $descCampo          += $desc;
        $liquidoCampo       += $row['valorliquido'];

        if($i+1 == mysqli_num_rows($valida)){
            $pdf -> SetFont('Arial','B','8');
            $pdf ->Cell("",1,"",1,1,'C');
            $pdf ->SetY($pdf->GetY() - 0.8);
            $pdf ->Cell(5.5,0.6,"SUBTOTAL ".$titulo.": ",0,0,'C');
            $pdf -> SetFont('Arial','','8');
            $pdf ->Cell(5.5,0.6,"VLR. BRUTO: R$ ".number_format($brutoCampo,2,",","."),0,0,'C');
            $pdf ->Cell(5,0.6,"JUROS: R$ ".number_format($jurosCampo,2,",","."),0,0,'C');
            $pdf ->Cell(5,0.6,"DESCONTO: R$ ".number_format($descCampo,2,",","."),0,0,'C');
            $pdf ->Cell(5.5,0.6,"VLR. LIQUIDO: R$ ".number_format($liquidoCampo,2,",","."),0,0,'C');
            $pdf ->SetY($pdf->GetY() + 0.2);

            $brutoData = $jurosData = $descData = $liquidoData = 0;
            $brutoCampo = $jurosCampo = $descCampo = $liquidoCampo = 0;
        }
        $i++;
    };
    $pdf -> SetFont('Arial','B','10');
    $pdf ->Cell("",1,"",0,1,'C');
    $pdf ->Cell("",1,"",1,1,'C');
    $pdf ->SetY($pdf->GetY() - 0.8);
    $pdf ->Cell(5.5,0.6,"TOTAL GERAL:",0,0,'C');
    $pdf ->Cell(5.5,0.6,"VLR. BRUTO: R$ ".number_format($brutoTotal,2,",","."),0,0,'C');
    $pdf ->Cell(5,0.6,"JUROS: R$ ".number_format($jurosTotal,2,",","."),0,0,'C');
    $pdf ->Cell(5,0.6,"DESCONTO: R$ ".number_format($descTotal,2,",","."),0,0,'C');
    $pdf ->Cell(5.5,0.6,"VLR. LIQUIDO: R$ ".number_format($liquidoTotal,2,",","."),0,0,'C');
    $pdf ->SetY($pdf->GetY() + 0.2);
}else{
    ?>
    <script>
        alert("<?php echo utf8_decode('Nenhuma informação encontrada!');?>");
        window.close();
    </script>
    <?php
}

$pdf -> Output('Financeiro'.date("d-m-Y").'.pdf','I');


?>