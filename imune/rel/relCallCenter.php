<?php

require_once "../server/seguranca.php";
require_once "fpdf/fpdf.php";
$den        = $_GET['den'];
$tipo       = $_GET['tipo'];
$cli_id     = $_GET['cliente'];
$status     = $_GET['status'];
$resultado  = $_GET['resultado'];
$data       = explode(",",$_GET['data']);
$data       = $data[0]." - ".$data[1];
$dt_ini     = $_GET['dt_ini'];
$dt_fim     = $_GET['dt_fim'];
$order      = $_GET['order'];
$emp_id     = $_SESSION['imunevacinas']['usuarioEmpresa'];
$query      = "select cliente.id as cli_id, consulta.id, cliente.ficha, usuarios.nome as dentista,concat(cliente.nome) as cliente, cliente.telefone, cliente.celular, consulta.dt_start, consulta.obs, consulta.status, cliente.motivo, cliente.ult_lig from cliente, consulta, usuarios where consulta.den_id = usuarios.id and consulta.cli_id = cliente.id and dt_start BETWEEN '".$dt_ini."' and '".$dt_fim."'" ;

if($den == '999'){

}else{
    $query .= " and consulta.den_id = $den ";
}

if($status == '999'){

}else{
    $query .= " and consulta.status = $status ";
}

if($resultado == '999'){

}else{
    $query .= " and cliente.motivo = $resultado ";
}

if($cli_id == '0'){

}else{
    $query .= " and cliente.id = $cli_id ";
}

if($order != ""){
    $query .= " order by ". $order;
}else{
    $query .= "order by dt_start asc";
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
        //Seleciona Arial it?lico 8
        $this->SetFont('Arial','I',8);
        //Imprime o n?mero da p?gina centralizado
        $this->Cell(0,11,'P?gina '.$this->PageNo(),0,0,'C');
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

$pdf=new PDF_AutoPrint('L','cm','A4');
$pdf->Open();

$valida = mysqli_query($con,$query);
if(mysqli_num_rows($valida) >= 1){
    $pdf->AddPage();
    $pdf -> SetFont('Arial','I','11');
    $pdf -> Cell("",1,"DATA: ".$data,0,1,'C');
    $pdf -> SetFont('Arial','B','15');
    $pdf -> Cell("",1,'RELAT�RIO CALLCENTER',0,1,'C');
    $st = "0";
    $array = [];
    $array['count'] = [];
    $array['title'] = [];
    array_push($array,$array['count']);
    array_push($array,$array['title']);
    $cont  = 1;
    $tcount = 0;
    $pdf -> SetFont('Arial','','8');

    if($order == 'consulta.dt_start asc ,consulta.dt_start'){
        $pdf -> Cell("",0.5,'ORDENADO POR DATA',0,1,'C');
        while($row = mysqli_fetch_array($valida)){
            $explode        = explode(" ",$row['dt_start']);
            $dtt            = substr($explode[0],8,2)."/".substr($explode[0],5,2)."/".substr($explode[0],0,4);
            $horario        = substr($explode[1],0,5);
            $paciente       = explode(" ",$row['cliente']);
            $paciente       = $row['ficha']." - ".@$paciente[0]." ".@$paciente[1]." ".@$paciente[3];
            $dentista       = strtoupper($row['dentista']);
            $obs            = $row['obs'];
            $motivo         = $row['motivo'];
            $telefone       = $row['telefone'];
            $celular        = $row['celular'];
            if(strlen($row['telefone']) == 8){
                $telefone = "31".$row['telefone'];
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            }else if(strlen($row['telefone']) == 0){

            }else{
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            };

            if(strlen($row['celular']) == 8){
                $celular = "319".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }
            else if(strlen($row['celular']) == 9){
                $celular = "31".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 10){
                $celular       = "(".substr($celular,0,2).") 9".substr($celular,2,4)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 0){

            }else{
                $celular        = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            };

            if(strlen($motivo) == 0 || $motivo == "0"){
                $motivo = "NENHUM CONTATO REALIZADO";
            }elseif($motivo == 1){
                $motivo = "CONTATO REALIZADO COM SUCESSO";
            }elseif($motivo == 2){
                $motivo = "RETORNAR LIGA��O MAIS TARDE";
            }elseif($motivo == 3){
                $motivo = "CAIXA POSTAL";
            }elseif($motivo == 4){
                $motivo = "TELEFONE OCULPADO";
            }elseif($motivo == 5){
                $motivo = "FORA DE AREA OU DESLIGADO";
            }elseif($motivo == 6){
                $motivo = "N�MERO DE TELEFONE N?O EXISTE";
            }elseif($motivo == 7){
                $motivo = "ENGANO / N?MERO ERRADO";
            };

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
            };

            if($st == $dtt){
                $pdf -> SetFont('Arial','','8');
                $cont++;
            }else{
                $pdf -> SetFont('Arial','B','15');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf ->Cell(4.5,1,$dtt,0,1,'L');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf->SetY($pdf->GetY() - 1);
                $pdf -> SetFont('Arial','B','8');

                //Define Cabe?alho com negrito
                $pdf ->SetTextColor(255,255,255);
                $pdf ->SetFillColor(60,115,60);
                $pdf ->SetDrawColor(10,45,10);
                $pdf ->Cell(1.5,1,'HORARIO',1,0,'C',1);
                $pdf ->Cell(6,1,'DENTISTA',1,0,'C',1);
                $pdf ->Cell(7,1,'PACIENTE',1,0,'C',1);
                $pdf ->Cell(2.5,1,'TELEFONE',1,0,'C',1);
                $pdf ->Cell(2.5,1,'CELULAR',1,0,'C',1);
                $pdf ->Cell(5.5,1,'MOTIVO',1,0,'C',1);
                $pdf ->Cell(2.5,1,'STATUS',1,1,'C',1);
                $pdf ->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
                $st         = $dtt;

                array_push($array['count'],$cont);
                array_push($array['title'],$dtt);
                $cont = 1;
            };
            if($cont%2==0){
                $pdf ->SetFillColor(191,221,207);
            }else{
                $pdf ->SetFillColor(255,255,255);
            }
            $pdf ->Cell(1.5,0.5,$horario,1,0,'C',1);
            $pdf ->Cell(6,0.5,$dentista,1,0,'C',1);
            $pdf ->Cell(7,0.5,$paciente,1,0,'C',1);
            $pdf ->Cell(2.5,0.5,$telefone,1,0,'C',1);
            $pdf ->Cell(2.5,0.5,$celular,1,0,'C',1);
            $pdf ->Cell(5.5,0.5,$motivo,1,0,'C',1);
            $pdf ->Cell(2.5,0.5,$st_nome,1,1,'C',1);
            $tcount++;
        }
        $pdf -> SetFont('Arial','B','15');
        $pdf ->SetTextColor(255,255,255);
        $pdf ->SetFillColor(60,115,60);
        $pdf ->SetDrawColor(10,45,10);
        $pdf -> Cell("",2,'',0,1,'C');
        $pdf -> Cell("",8,'',1,1,'C',1);
        $pdf->SetY($pdf->GetY() - 8);
        $pdf -> Cell("",3,'RESUMO CALLCENTER',0,1,'C');
        $ttt = 0;
        for($a = 1; $a < count($array['count']);$a++){
            if($a%2==0){
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(5,1,$array['title'][$a-1]." : ",0,0,'R');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,1,$array['count'][$a]." CONSULTA(s)",0,0,'R');
                $pdf -> Cell(4,1,"",0,1,'C');
            }else{
                $pdf -> Cell(4,1,"",0,0,'C');
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(5,1,$array['title'][$a-1]." : ",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,1,$array['count'][$a]." CONSULTA(s)",0,0,'L');
            }
            $ttt = $ttt + $array['count'][$a];
        }
        if($a%2==0){
            $pdf -> Cell(1.6,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,$array['title'][$a-1]." : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount-$ttt)." CONSULTA(s)",0,1,'L');

            $pdf -> Cell(4,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,"TOTAL : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount)." CONSULTA(s)",0,1,'L');
        }else{
            $pdf -> Cell(4,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,$array['title'][$a-1]." : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount-$ttt)." CONSULTA(s)",0,0,'L');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5.7,1,"TOTAL : ",0,0,'C');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount)." CONSULTA(s)",0,1,'C');
        }
    }
    elseif($order == 'usuarios.nome asc ,consulta.dt_start'){
        $pdf -> Cell("",0.5,'ORDENADO POR DENTISTA',0,1,'C');
        while($row = mysqli_fetch_array($valida)){
            $explode        = explode(" ",$row['dt_start']);
            $dtt            = substr($explode[0],8,2)."/".substr($explode[0],5,2)."/".substr($explode[0],0,4);
            $horario        = substr($explode[1],0,5);
            $paciente       = explode(" ",$row['cliente']);
            $paciente       = $row['ficha']." - ".@$paciente[0]." ".@$paciente[1]." ".@$paciente[3];
            $dentista       = explode(" ",$row['dentista']);
            $dentista       = strtoupper(@$dentista[0]." ".@$dentista[count($dentista)-1]);
            $obs            = $row['obs'];
            $motivo         = $row['motivo'];
            $telefone       = $row['telefone'];
            $celular        = $row['celular'];
            if(strlen($row['telefone']) == 8){
                $telefone = "31".$row['telefone'];
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            }else if(strlen($row['telefone']) == 0){

            }else{
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            };

            if(strlen($row['celular']) == 8){
                $celular = "319".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }
            else if(strlen($row['celular']) == 9){
                $celular = "31".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 10){
                $celular       = "(".substr($celular,0,2).") 9".substr($celular,2,4)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 0){

            }else{
                $celular        = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            };

            if(strlen($motivo) == 0 || $motivo == "0"){
                $motivo = "NENHUM CONTATO REALIZADO";
            }elseif($motivo == 1){
                $motivo = "CONTATO REALIZADO COM SUCESSO";
            }elseif($motivo == 2){
                $motivo = "RETORNAR LIGA??O MAIS TARDE";
            }elseif($motivo == 3){
                $motivo = "CAIXA POSTAL";
            }elseif($motivo == 4){
                $motivo = "TELEFONE OCULPADO";
            }elseif($motivo == 5){
                $motivo = "FORA DE AREA OU DESLIGADO";
            }elseif($motivo == 6){
                $motivo = "N?MERO DE TELEFONE N?O EXISTE";
            }elseif($motivo == 7){
                $motivo = "ENGANO / N?MERO ERRADO";
            };

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
            };

            if($st == $dentista){
                $pdf -> SetFont('Arial','','8');
                $cont++;
            }else{
                $pdf -> SetFont('Arial','B','15');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf ->Cell(4.5,1,$dentista,0,1,'L');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf->SetY($pdf->GetY() - 1);
                $pdf -> SetFont('Arial','B','8');

                //Define Cabe?alho com negrito
                $pdf ->SetTextColor(255,255,255);
                $pdf ->SetFillColor(60,115,60);
                $pdf ->SetDrawColor(10,45,10);
                $pdf ->Cell(2,1,'DATA',1,0,'C',1);
                $pdf ->Cell(2,1,'HORARIO',1,0,'C',1);
                $pdf ->Cell(7.5,1,'PACIENTE',1,0,'C',1);
                $pdf ->Cell(3.5,1,'TELEFONE',1,0,'C',1);
                $pdf ->Cell(3.5,1,'CELULAR',1,0,'C',1);
                $pdf ->Cell(5.5,1,'MOTIVO',1,0,'C',1);
                $pdf ->Cell(3.5,1,'STATUS',1,1,'C',1);
                $pdf ->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
                $st         = $dentista;

                array_push($array['count'],$cont);
                array_push($array['title'],$dentista);
                $cont = 1;
            };
            if($cont%2==0){
                $pdf ->SetFillColor(191,221,207);
            }else{
                $pdf ->SetFillColor(255,255,255);
            }
            $pdf ->Cell(2,0.5,$dtt,1,0,'C',1);
            $pdf ->Cell(2,0.5,$horario,1,0,'C',1);
            $pdf ->Cell(7.5,0.5,$paciente,1,0,'C',1);
            $pdf ->Cell(3.5,0.5,$telefone,1,0,'C',1);
            $pdf ->Cell(3.5,0.5,$celular,1,0,'C',1);
            $pdf ->Cell(5.5,0.5,$motivo,1,0,'C',1);
            $pdf ->Cell(3.5,0.5,$st_nome,1,1,'C',1);
            $tcount++;
        }
        $pdf -> SetFont('Arial','B','15');

        $pdf -> Cell("",2,'',0,1,'C');


        $pdf -> Cell("",3,'RESUMO CALLCENTER',0,1,'C');
        $ttt = 0;
        for($a = 1; $a < count($array['count']);$a++){
            if($a%2==0){
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(5,1,$array['title'][$a-1]." : ",0,0,'R');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,1,$array['count'][$a]." CONSULTA(s)",0,0,'R');
                $pdf -> Cell(4,1,"",0,1,'C');
            }else{
                $pdf -> Cell(4,1,"",0,0,'C');
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(5,1,$array['title'][$a-1]." : ",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,1,$array['count'][$a]." CONSULTA(s)",0,0,'L');
            }
            $ttt = $ttt + $array['count'][$a];
        }
        if($a%2==0){
            $pdf -> Cell(1.6,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,$array['title'][$a-1]." : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount-$ttt)." CONSULTA(s)",0,1,'L');

            $pdf -> Cell(4,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,"TOTAL : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount)." CONSULTA(s)",0,1,'L');
        }else{
            $pdf -> Cell(4,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,$array['title'][$a-1]." : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount-$ttt)." CONSULTA(s)",0,0,'L');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5.7,1,"TOTAL : ",0,0,'C');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount)." CONSULTA(s)",0,1,'C');
        }
    }
    elseif($order == 'cliente.nome asc ,consulta.dt_start'){
        $pdf -> Cell("",0.5,'ORDENADO POR CLIENTE',0,1,'C');
        while($row = mysqli_fetch_array($valida)){
            $explode        = explode(" ",$row['dt_start']);
            $dtt            = substr($explode[0],8,2)."/".substr($explode[0],5,2)."/".substr($explode[0],0,4);
            $horario        = substr($explode[1],0,5);
            $paciente       = explode(" ",$row['cliente']);
            $paciente       = $row['ficha']." - ".@$paciente[0]." ".@$paciente[1]." ".@$paciente[3];
            $dentista       = explode(" ",$row['dentista']);
            $dentista       = strtoupper(@$dentista[0]." ".@$dentista[count($dentista)-1]);
            $obs            = $row['obs'];
            $motivo         = $row['motivo'];
            $telefone       = $row['telefone'];
            $celular        = $row['celular'];
            if(strlen($row['telefone']) == 8){
                $telefone = "31".$row['telefone'];
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            }else if(strlen($row['telefone']) == 0){

            }else{
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            };

            if(strlen($row['celular']) == 8){
                $celular = "319".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }
            else if(strlen($row['celular']) == 9){
                $celular = "31".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 10){
                $celular       = "(".substr($celular,0,2).") 9".substr($celular,2,4)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 0){

            }else{
                $celular        = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            };

            if(strlen($motivo) == 0 || $motivo == "0"){
                $motivo = "NENHUM CONTATO REALIZADO";
            }elseif($motivo == 1){
                $motivo = "CONTATO REALIZADO COM SUCESSO";
            }elseif($motivo == 2){
                $motivo = "RETORNAR LIGA��O MAIS TARDE";
            }elseif($motivo == 3){
                $motivo = "CAIXA POSTAL";
            }elseif($motivo == 4){
                $motivo = "TELEFONE OCULPADO";
            }elseif($motivo == 5){
                $motivo = "FORA DE AREA OU DESLIGADO";
            }elseif($motivo == 6){
                $motivo = "N�MERO DE TELEFONE N�O EXISTE";
            }elseif($motivo == 7){
                $motivo = "ENGANO / N�MERO ERRADO";
            };

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
            };

            if($st == $paciente){
                $pdf -> SetFont('Arial','','8');
                $cont++;
            }else{
                $pdf -> SetFont('Arial','B','15');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf ->Cell(4.5,1,$paciente,0,1,'L');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf->SetY($pdf->GetY() - 1);
                $pdf -> SetFont('Arial','B','8');

                //Define Cabe?alho com negrito
                $pdf ->SetTextColor(255,255,255);
                $pdf ->SetFillColor(60,115,60);
                $pdf ->SetDrawColor(10,45,10);
                $pdf ->Cell(2,1,'DATA',1,0,'C',1);
                $pdf ->Cell(3,1,'HORARIO',1,0,'C',1);
                $pdf ->Cell(5.5,1,'DENTISTA',1,0,'C',1);
                $pdf ->Cell(3.5,1,'TELEFONE',1,0,'C',1);
                $pdf ->Cell(3.5,1,'CELULAR',1,0,'C',1);
                $pdf ->Cell(6,1,'MOTIVO',1,0,'C',1);
                $pdf ->Cell(4,1,'STATUS',1,1,'C',1);
                $pdf ->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
                $st         = $paciente;

                array_push($array['count'],$cont);
                array_push($array['title'],$paciente);
                $cont = 1;
            };
            if($cont%2==0){
                $pdf ->SetFillColor(191,221,207);
            }else{
                $pdf ->SetFillColor(255,255,255);
            }
            $pdf ->Cell(2,0.5,$dtt,1,0,'C',1);
            $pdf ->Cell(3,0.5,$horario,1,0,'C',1);
            $pdf ->Cell(5.5,0.5,$dentista,1,0,'C',1);
            $pdf ->Cell(3.5,0.5,$telefone,1,0,'C',1);
            $pdf ->Cell(3.5,0.5,$celular,1,0,'C',1);
            $pdf ->Cell(6,0.5,$motivo,1,0,'C',1);
            $pdf ->Cell(4,0.5,$st_nome,1,1,'C',1);
            $tcount++;
        }
        $pdf -> SetFont('Arial','B','15');

        $pdf -> Cell("",2,'',0,1,'C');

        $pdf -> Cell("",3,'RESUMO CALLCENTER',0,1,'C');
        $ttt = 0;
        for($a = 1; $a < count($array['count']);$a++){
            $pdf -> Cell(4,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(15,1,$array['title'][$a-1]." : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,$array['count'][$a]." CONSULTA(s)",0,1,'L');
            $ttt = $ttt + $array['count'][$a];
        }
        $pdf -> Cell(4,1,"",0,0,'C');
        $pdf -> SetFont('Arial','B','12');
        $pdf -> Cell(15,1,$array['title'][$a-1]." : ",0,0,'L');
        $pdf -> SetFont('Arial','','12');
        $pdf -> Cell(5,1,($tcount-$ttt)." CONSULTA(s)",0,1,'L');
        $pdf -> SetFont('Arial','B','12');
        $pdf -> Cell(4,1,"",0,0,'C');
        $pdf -> Cell(15,1,"TOTAL : ",0,0,'L');
        $pdf -> SetFont('Arial','','12');
        $pdf -> Cell(5,1,($tcount)." CONSULTA(s)",0,1,'L');
    }
    elseif($order == 'cliente.motivo asc ,consulta.dt_start'){
        $pdf -> Cell("",0.5,'ORDENADO POR CLIENTE',0,1,'C');
        while($row = mysqli_fetch_array($valida)){
            $explode        = explode(" ",$row['dt_start']);
            $dtt            = substr($explode[0],8,2)."/".substr($explode[0],5,2)."/".substr($explode[0],0,4);
            $horario        = substr($explode[1],0,5);
            $paciente       = explode(" ",$row['cliente']);
            $paciente       = $row['ficha']." - ".@$paciente[0]." ".@$paciente[1]." ".@$paciente[3];
            $dentista       = explode(" ",$row['dentista']);
            $dentista       = strtoupper(@$dentista[0]." ".@$dentista[count($dentista)-1]);
            $obs            = $row['obs'];
            $motivo         = $row['motivo'];
            $telefone       = $row['telefone'];
            $celular        = $row['celular'];
            if(strlen($row['telefone']) == 8){
                $telefone = "31".$row['telefone'];
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            }else if(strlen($row['telefone']) == 0){

            }else{
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            };

            if(strlen($row['celular']) == 8){
                $celular = "319".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }
            else if(strlen($row['celular']) == 9){
                $celular = "31".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 10){
                $celular       = "(".substr($celular,0,2).") 9".substr($celular,2,4)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 0){

            }else{
                $celular        = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            };

            if(strlen($motivo) == 0 || $motivo == "0"){
                $motivo = "NENHUM CONTATO REALIZADO";
            }elseif($motivo == 1){
                $motivo = "CONTATO REALIZADO COM SUCESSO";
            }elseif($motivo == 2){
                $motivo = "RETORNAR LIGA��O MAIS TARDE";
            }elseif($motivo == 3){
                $motivo = "CAIXA POSTAL";
            }elseif($motivo == 4){
                $motivo = "TELEFONE OCULPADO";
            }elseif($motivo == 5){
                $motivo = "FORA DE AREA OU DESLIGADO";
            }elseif($motivo == 6){
                $motivo = "N�MERO DE TELEFONE N�O EXISTE";
            }elseif($motivo == 7){
                $motivo = "ENGANO / N�MERO ERRADO";
            };

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
            };

            if($st == $motivo){
                $pdf -> SetFont('Arial','','8');
                $cont++;
            }else{
                $pdf -> SetFont('Arial','B','15');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf ->Cell(4.5,1,$motivo,0,1,'L');
                $pdf ->Cell(1,1,"",0,1,'C');
                $pdf->SetY($pdf->GetY() - 1);
                $pdf -> SetFont('Arial','B','8');

                //Define Cabe?alho com negrito
                $pdf ->SetTextColor(255,255,255);
                $pdf ->SetFillColor(60,115,60);
                $pdf ->SetDrawColor(10,45,10);
                $pdf ->Cell(2,1,'DATA',1,0,'C',1);
                $pdf ->Cell(3,1,'HORARIO',1,0,'C',1);
                $pdf ->Cell(4,1,'DENTISTA',1,0,'C',1);
                $pdf ->Cell(7.5,1,'PACIENTE',1,0,'C',1);
                $pdf ->Cell(3.5,1,'TELEFONE',1,0,'C',1);
                $pdf ->Cell(3.5,1,'CELULAR',1,0,'C',1);
                $pdf ->Cell(4,1,'STATUS',1,1,'C',1);
                $pdf ->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
                $st         = $motivo;

                array_push($array['count'],$cont);
                array_push($array['title'],$motivo);
                $cont = 1;
            };
            if($cont%2==0){
                $pdf ->SetFillColor(191,221,207);
            }else{
                $pdf ->SetFillColor(255,255,255);
            }
            $pdf ->Cell(2,0.5,$dtt,1,0,'C',1);
            $pdf ->Cell(3,0.5,$horario,1,0,'C',1);
            $pdf ->Cell(4,0.5,$dentista,1,0,'C',1);
            $pdf ->Cell(7.5,0.5,$paciente,1,0,'C',1);
            $pdf ->Cell(3.5,0.5,$telefone,1,0,'C',1);
            $pdf ->Cell(3.5,0.5,$celular,1,0,'C',1);
            $pdf ->Cell(4,0.5,$st_nome,1,1,'C',1);
            $tcount++;
        }
        $pdf -> SetFont('Arial','B','15');

        $pdf -> Cell("",2,'',0,1,'C');

        $pdf -> Cell("",3,'RESUMO CALLCENTER',0,1,'C');
        $ttt = 0;
        for($a = 1; $a < count($array['count']);$a++){
            $pdf -> Cell(4,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(15,1,$array['title'][$a-1]." : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,$array['count'][$a]." CONSULTA(s)",0,1,'L');
            $ttt = $ttt + $array['count'][$a];
        }
        $pdf -> Cell(4,1,"",0,0,'C');
        $pdf -> SetFont('Arial','B','12');
        $pdf -> Cell(15,1,$array['title'][$a-1]." : ",0,0,'L');
        $pdf -> SetFont('Arial','','12');
        $pdf -> Cell(5,1,($tcount-$ttt)." CONSULTA(s)",0,1,'L');
        $pdf -> SetFont('Arial','B','12');
        $pdf -> Cell(4,1,"",0,0,'C');
        $pdf -> Cell(15,1,"TOTAL : ",0,0,'L');
        $pdf -> SetFont('Arial','','12');
        $pdf -> Cell(5,1,($tcount)." CONSULTA(s)",0,1,'L');
    }
    elseif($order == 'consulta.status asc ,consulta.dt_start'){

        $pdf -> Cell("",0.5,'ORDENADO POR STATUS',0,1,'C');
        while($row = mysqli_fetch_array($valida)){
            $explode        = explode(" ",$row['dt_start']);
            $dtt            = substr($explode[0],8,2)."/".substr($explode[0],5,2)."/".substr($explode[0],0,4);
            $horario        = substr($explode[1],0,5);
            $paciente       = explode(" ",$row['cliente']);
            $paciente       = $row['ficha']." - ".@$paciente[0]." ".@$paciente[1]." ".@$paciente[3];
            $dentista       = strtoupper($row['dentista']);
            $obs            = $row['obs'];
            $motivo         = $row['motivo'];
            $telefone       = $row['telefone'];
            $celular        = $row['celular'];
            if(strlen($row['telefone']) == 8){
                $telefone = "31".$row['telefone'];
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            }else if(strlen($row['telefone']) == 0){

            }else{
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            };

            if(strlen($row['celular']) == 8){
                $celular = "319".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }
            else if(strlen($row['celular']) == 9){
                $celular = "31".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 10){
                $celular       = "(".substr($celular,0,2).") 9".substr($celular,2,4)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 0){

            }else{
                $celular        = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            };

            if(strlen($motivo) == 0 || $motivo == "0"){
                $motivo = "NENHUM CONTATO REALIZADO";
            }elseif($motivo == 1){
                $motivo = "CONTATO REALIZADO COM SUCESSO";
            }elseif($motivo == 2){
                $motivo = "RETORNAR LIGA��O MAIS TARDE";
            }elseif($motivo == 3){
                $motivo = "CAIXA POSTAL";
            }elseif($motivo == 4){
                $motivo = "TELEFONE OCULPADO";
            }elseif($motivo == 5){
                $motivo = "FORA DE AREA OU DESLIGADO";
            }elseif($motivo == 6){
                $motivo = "N�MERO DE TELEFONE N�O EXISTE";
            }elseif($motivo == 7){
                $motivo = "ENGANO / N�MERO ERRADO";
            };

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
            };

            if($st == $row['status']){
                $pdf -> SetFont('Arial','','8');
                $cont++;

            }else{
                $pdf -> SetFont('Arial','B','15');
                $pdf ->Cell(1,0.5,"",0,1,'C');
                $pdf ->Cell(4.5,0.5,$st_nome,0,1,'L');
                $pdf ->Cell(1,0.5,"",0,1,'C');
                $pdf -> SetFont('Arial','B','8');

                //Define Cabe?alho com negrito
                $pdf ->SetTextColor(255,255,255);
                $pdf ->SetFillColor(60,115,60);
                $pdf ->SetDrawColor(10,45,10);
                $pdf ->Cell(2,1,'DATA',1,0,'C',1);
                $pdf ->Cell(1.5,1,'HORARIO',1,0,'C',1);
                $pdf ->Cell(6,1,'DENTISTA',1,0,'C',1);
                $pdf ->Cell(7,1,'PACIENTE',1,0,'C',1);
                $pdf ->Cell(2.5,1,'TELEFONE',1,0,'C',1);
                $pdf ->Cell(2.5,1,'CELULAR',1,0,'C',1);
                $pdf ->Cell(6,1,'MOTIVO',1,1,'C',1);
                $pdf ->SetTextColor(0,0,0);
                $pdf -> SetFont('Arial','','8');
                $st         = $row['status'];
                if($row['status'] == 1){
                    $st_nom = "AGENDADAS";
                }elseif($row['status'] == 3){
                    $st_nom = "CONFIRMADAS";
                }elseif($row['status'] == 4){
                    $st_nom = "COMPARECIDAS";
                }elseif($row['status'] == 5){
                    $st_nom = "REMARCADAS";
                }elseif($row['status'] == 6){
                    $st_nom = "FALTANTES";
                }elseif($row['status'] == 7){
                    $st_nom = "ATRASADAS";
                }elseif($row['status'] == 8){
                    $st_nom = "ENCAIXADAS";
                }
                array_push($array['count'],$cont);
                array_push($array['title'],$st_nom);
                $cont = 1;
            };
            if($cont%2==0){
                $pdf ->SetFillColor(191,221,207);
            }else{
                $pdf ->SetFillColor(255,255,255);
            }
            $pdf ->Cell(2,0.5,$dtt,1,0,'C',1);
            $pdf ->Cell(1.5,0.5,$horario,1,0,'C',1);
            $pdf ->Cell(6,0.5,$dentista,1,0,'C',1);
            $pdf ->Cell(7,0.5,$paciente,1,0,'C',1);
            $pdf ->Cell(2.5,0.5,$telefone,1,0,'C',1);
            $pdf ->Cell(2.5,0.5,$celular,1,0,'C',1);
            $pdf ->Cell(6,0.5,$motivo,1,1,'C',1);
            $tcount++;
        }
        $pdf -> SetFont('Arial','B','15');
        $pdf ->SetTextColor(255,255,255);
        $pdf ->SetFillColor(60,115,60);
        $pdf ->SetDrawColor(10,45,10);
        $pdf -> Cell("",2,'',0,1,'C');
        $pdf -> Cell("",8,'',1,1,'C',1);
        $pdf->SetY($pdf->GetY() - 8);
        $pdf -> Cell("",3,'RESUMO CALLCENTER',0,1,'C');
        $ttt = 0;
        for($a = 1; $a < count($array['count']);$a++){
            if($a%2==0){
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(5,1,$array['title'][$a]." : ",0,0,'R');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,1,$array['count'][$a]." CONSULTA(s)",0,0,'R');
                $pdf -> Cell(4,1,"",0,1,'C');
            }else{
                $pdf -> Cell(4,1,"",0,0,'C');
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(5,1,$array['title'][$a]." : ",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,1,$array['count'][$a]." CONSULTA(s)",0,0,'L');
            }
            $ttt = $ttt + $array['count'][$a];
        }
        if($a%2==0){
            $pdf -> Cell(1.6,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,$st_nome." : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount-$ttt)." CONSULTA(s)",0,1,'L');

            $pdf -> Cell(4,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,"TOTAL : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount)." CONSULTA(s)",0,1,'L');
        }else{
            $pdf -> Cell(4,1,"",0,0,'C');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5,1,$st_nome." : ",0,0,'L');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount-$ttt)." CONSULTA(s)",0,0,'L');
            $pdf -> SetFont('Arial','B','12');
            $pdf -> Cell(5.7,1,"TOTAL : ",0,0,'C');
            $pdf -> SetFont('Arial','','12');
            $pdf -> Cell(5,1,($tcount)." CONSULTA(s)",0,1,'C');
        }
    }
    else{
        $pdf -> Cell("",0.5,'GERAL',0,1,'C');
        $pdf -> SetFont('Arial','B','15');
        $pdf ->Cell(1,0.5,"",0,1,'C');

        $pdf ->Cell(1,0.5,"",0,1,'C');
        $pdf -> SetFont('Arial','B','7');

        //Define Cabe?alho com negrito
        $pdf ->SetTextColor(255,255,255);
        $pdf ->SetFillColor(60,115,60);
        $pdf ->SetDrawColor(10,45,10);
        $pdf ->Cell(1.5,1,'DATA',1,0,'C',1);
        $pdf ->Cell(1.5,1,'HORARIO',1,0,'C',1);
        $pdf ->Cell(4,1,'DENTISTA',1,0,'C',1);
        $pdf ->Cell(7,1,'PACIENTE',1,0,'C',1);
        $pdf ->Cell(2.5,1,'TELEFONE',1,0,'C',1);
        $pdf ->Cell(2.5,1,'CELULAR',1,0,'C',1);
        $pdf ->Cell(5.5,1,'MOTIVO',1,0,'C',1);
        $pdf ->Cell(3,1,'STATUS',1,1,'C',1);
        $pdf ->SetTextColor(0,0,0);
        $pdf -> SetFont('Arial','','7');

        $d = [];
        $dd = 0;
        $ddd = [];
        $dttt = "";
        while($row = mysqli_fetch_array($valida)){
            $explode        = explode(" ",$row['dt_start']);
            $dtt            = substr($explode[0],8,2)."/".substr($explode[0],5,2)."/".substr($explode[0],0,4);
            $horario        = substr($explode[1],0,5);
            $paciente       = explode(" ",$row['cliente']);
            $paciente       = $row['ficha']." - ".@$paciente[0]." ".@$paciente[1]." ".@$paciente[3];
            $dentista       = explode(" ",$row['dentista']);
            $dentista       = strtoupper(@$dentista[0]." ".@$dentista[count($dentista)-1]);
            $obs            = $row['obs'];
            $motivo         = $row['motivo'];
            $telefone       = $row['telefone'];
            $celular        = $row['celular'];


            if(strlen($row['telefone']) == 8){
                $telefone = "31".$row['telefone'];
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            }else if(strlen($row['telefone']) == 0){

            }else{
                $telefone       = "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
            };

            if(strlen($row['celular']) == 8){
                $celular = "319".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }
            else if(strlen($row['celular']) == 9){
                $celular = "31".$row['celular'];
                $celular       = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 10){
                $celular       = "(".substr($celular,0,2).") 9".substr($celular,2,4)."-".substr($celular,6,4);
            }else if(strlen($row['celular']) == 0){

            }else{
                $celular        = "(".substr($celular,0,2).") ".substr($celular,2,5)."-".substr($celular,6,4);
            };



            if(strlen($motivo) == 0 || $motivo == "0"){

                $motivo = "NENHUM CONTATO REALIZADO";
                $m[0] = [
                    'valor' => @$mm[0]++,
                    'title' => $motivo
                ];
            }elseif($motivo == 1){
                $motivo = "CONTATO REALIZADO COM SUCESSO";
                $m[1] = [
                    'valor' => @$mm[1]++,
                    'title' => $motivo
                ];

            }elseif($motivo == 2){
                $motivo = "RETORNAR LIGA��O MAIS TARDE";
                $m[2] = [
                    'valor' => @$mm[2]++,
                    'title' => $motivo
                ];
            }elseif($motivo == 3){
                $motivo = "CAIXA POSTAL";
                $m[3] = [
                    'valor' => @$mm[3]++,
                    'title' => $motivo
                ];
            }elseif($motivo == 4){@$m['4']++;
                $motivo = "TELEFONE OCULPADO";
                $m[4] = [
                    'valor' => @$mm[4]++,
                    'title' => $motivo
                ];
            }elseif($motivo == 5){
                $motivo = "FORA DE AREA OU DESLIGADO";
                $m[5] = [
                    'valor' => @$mm[5]++,
                    'title' => $motivo
                ];
            }elseif($motivo == 6){
                $motivo = "N�MERO DE TELEFONE N�O EXISTE";
                $m[6] = [
                    'valor' => @$mm[6]++,
                    'title' => $motivo
                ];
            }elseif($motivo == 7){
                $motivo = "ENGANO / N�MERO ERRADO";
                $m[7] = [
                    'valor' => @$mm[7]++,
                    'title' => $motivo
                ];
            };

            if($row['status'] == 1){
                $st_nome = "AGENDADAS";
                $s[0] = [
                    'valor' => @$ss[0]++,
                    'title' => $st_nome
                ];
            }elseif($row['status'] == 2){
                $st_nome = "CONFIRMADAS";
                $s[1] = [
                    'valor' => @$ss[1]++,
                    'title' => $st_nome
                ];
            }elseif($row['status'] == 3){
                $st_nome = "COMPARECIDAS";
                $s[2] = [
                    'valor' => @$ss[2]++,
                    'title' => $st_nome
                ];
            }elseif($row['status'] == 4){
                $st_nome = "REMARCADAS";
                $s[3] = [
                    'valor' => @$ss[3]++,
                    'title' => $st_nome
                ];
            }elseif($row['status'] == 5){
                $st_nome = "FALTANTES";
                $s[4] = [
                    'valor' => @$ss[4]++,
                    'title' => $st_nome
                ];
            }elseif($row['status'] == 6){
                $st_nome = "ATRASADAS";
                $s[5] = [
                    'valor' => @$ss[5]++,
                    'title' => $st_nome
                ];
            }elseif($row['status'] == 7){
                $st_nome = "ENCAIXADAS";
                $s[6] = [
                    'valor' => @$ss[6]++,
                    'title' => $st_nome
                ];
            };

            if($tcount%2==1){
                $pdf ->SetFillColor(191,221,207);
            }else{
                $pdf ->SetFillColor(255,255,255);
            }
            $pdf ->Cell(1.5,0.5,$dtt,1,0,'C',1);
            $pdf ->Cell(1.5,0.5,$horario,1,0,'C',1);
            $pdf ->Cell(4,0.5,$dentista,1,0,'C',1);
            $pdf ->Cell(7,0.5,$paciente,1,0,'C',1);
            $pdf ->Cell(2.5,0.5,$telefone,1,0,'C',1);
            $pdf ->Cell(2.5,0.5,$celular,1,0,'C',1);
            $pdf ->Cell(5.5,0.5,$motivo,1,0,'C',1);
            $pdf ->Cell(3,0.5,$st_nome,1,1,'C',1);
            $tcount++;
        }
        $pdf->AddPage();
        $pdf -> SetFont('Arial','B','15');
        $pdf -> Cell("",3,'RESUMO CALLCENTER',0,1,'C');
        $pdf -> SetFont('Arial','','11');
        $pdf->SetY($pdf->GetY() - 2.5);
        $pdf -> Cell("",4,'RESUMO POR STATUS',0,1,'C');
        $ss= 0;
        $pdf->SetY($pdf->GetY() - 1);
        foreach ( $s as $value ) {
            $ss++;
            if($ss%2==1){

                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(6,1,$value['title']." : ",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,1,($value['valor']+1)." CONSULTA(s)",0,0,'R');
            }else{
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(5,1,"",0,0,'L');
                $pdf -> Cell(6,1,$value['title']." : ",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,1,($value['valor']+1)." CONSULTA(s)",0,1,'R');
            }
        }
        $pdf -> Cell("",1,"",0,1,'C');
        $pdf -> SetFont('Arial','','11');

        $pdf -> Cell("",4,'RESUMO POR RESULTADOS',0,1,'C');
        $mm = 0;
        foreach ( $m as $value ) {
            $mm++;
            if($mm%2==1){
                $pdf->SetY($pdf->GetY() - 2);
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(8,3,$value['title']." : ",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,3,($value['valor']+1)." CONSULTA(s)",0,0,'R');
            }else{
                $pdf -> SetFont('Arial','B','12');
                $pdf -> Cell(1,3,"",0,0,'L');
                $pdf -> Cell(8,3,$value['title']." : ",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf -> Cell(5,3,($value['valor']+1)." CONSULTA(s)",0,1,'R');
            }
        }

        $ttt = 0;

    }
    $pdf -> SetFont('Arial','','10');
    //$pdf->AutoPrint(false);
    $pdf -> Output('RelConsulta'.$data.'.pdf','I');

}else{
    ?>
    <script>
        alert("Valores n�o encontrados!");
        window.close();
    </script>
    <?php
}





?>