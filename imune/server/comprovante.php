<?php
    require_once "seguranca.php";
    require_once "../rel/fpdf/fpdf.php";


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
            $this -> Cell("",1,utf8_decode("GERADO POR: ".$_SESSION['imunevacinas']['usuarioNome'])." - ".date('d/m/Y H:i:s',strtotime('-2 hours')),0,1,'R');

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

    @$titulos       = explode(",",$_REQUEST['titulos']);
    @$funcao        = $_REQUEST['funcao'];
    @$produtor      = $_REQUEST['produtor'];
    @$data          = date('d/m/Y H:i:s');
    @$dt_cad        = date('Y-m-d H:i:s');
    @$i			    = 0;
    @$total			= 0;
    @$pes_id	    = 0;

    $pdf=new PDF_AutoPrint('P','cm','A4');
    $pdf->Open();


    if($funcao == 1){
        while($i < count($titulos)){
        $query = "select financeiro.status,financeiro.id,financeiro.pes_id,financeiro.dt_emi, financeiro.dt_fat,financeiro.dt_baixa, financeiro.apo_id, pessoa.nome as pessoa, pessoa.cpf, empresa.razao as empresa, banco.banco as banco, pagamento.nome as pagamento, centrocusto.nome as centrocusto, natureza.nome as natureza, financeiro.valorbruto, financeiro.valorliquido, financeiro.obs from financeiro,pessoa,empresa,banco,pagamento,centrocusto,natureza where pessoa.id = financeiro.pes_id and empresa.id = financeiro.emp_id and banco.id = financeiro.ban_id and pagamento.id = financeiro.pag_id and centrocusto.id = financeiro.cen_id and natureza.id = financeiro.nat_id  and financeiro.id = '$titulos[$i]'";
            //echo $query;
            $valida = mysqli_query($con,$query);
            if($row = mysqli_fetch_array($valida)){
                if($i%3 == 0){
                    $pdf->AddPage();
                }
                if(strlen($row['cpf']) == 11){
                    $cpf = substr($row['cpf'],0,3).".".substr($row['cpf'],3,3).".".substr($row['cpf'],6,3)."-".substr($row['cpf'],9,2);
                }else if(strlen($row['cpf']) == 14){
                    $cpf = substr($row['cpf'],0,2).".".substr($row['cpf'],2,3).".".substr($row['cpf'],5,3)."/".substr($row['cpf'],8,4)."-".substr($row['cpf'],11,2);
                }else{
                    $cpf = "CPF / CNPJ INCORRETO NO CADASTRO! FAVOR VERIFICAR!";
                }

                $pdf ->Cell("",7.5,"",1,1,'L');
                $pdf->SetY($pdf->GetY() - 7.2);
                $pdf -> SetFont('Arial','I','11');
                $pdf -> Cell("",0.5,utf8_decode("TÍTULO N°: ".$row['id']."  -  DATA: ".$data),0,1,'C');
                $pdf -> SetFont('Arial','B','15');
                if($row['status'] == 4){
                    $pdf -> Cell("",1,'COMPROVANTE DE RECEBIMENTO',0,1,'C');
                }elseif($row['status'] == 3){
                    if($row['valorliquido'] >=0){
                        $pdf -> Cell("",1,utf8_decode('COMPROVANTE DE PAGAMENTO DE PREMIAÇÃO'),0,1,'C');
                    }else{
                        $pdf -> Cell("",1,utf8_decode('COMPROVANTE DE ADIANTAMENTO DE COMISSÃO'),0,1,'C');
                        $row['valorliquido'] = $row['valorliquido']*(-1);
                    }
                }
                $pdf -> SetFont('Arial','B','12');
                $pdf ->Cell(0.5,0.8,"",0,0,'L');
                $pdf ->Cell(3.6,0.8,"SOLICITANTE:",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf ->Cell("",0.8,strtoupper($row['pes_id']." - ".$row['pessoa']),0,1,'L');
                $pdf -> SetFont('Arial','B','12');
                $pdf ->Cell(0.5,0.8,"",0,0,'L');
                $pdf ->Cell(3.6,0.8,"CPF/CNPJ:",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf ->Cell("",0.8,$cpf,0,1,'L');
                $pdf -> SetFont('Arial','B','12');
                $pdf ->Cell(0.5,0.8,"",0,0,'L');
                $pdf ->Cell(3.6,0.8,"EMPRESA:",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf ->Cell("",0.8,$row['empresa'],0,1,'L');
                $pdf -> SetFont('Arial','B','12');
                $pdf ->Cell(0.5,0.8,"",0,0,'L');
                $pdf ->Cell(3.6,0.8,"BANCO:",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf ->Cell("",0.8,$row['banco'],0,1,'L');
                $pdf -> SetFont('Arial','B','12');
                $pdf ->Cell(0.5,0.8,"",0,0,'L');
                $pdf ->Cell(3.6,0.8,"PAGAMENTO:",0,0,'L');
                $pdf -> SetFont('Arial','','12');
                $pdf ->Cell("3",0.8,"R$ ".number_format($row['valorliquido'],2,',','.')."  -  ".$row['pagamento'],0,1,'L');
                $pdf ->Cell("",0.3,"",0,1,'L');
                $pdf ->Cell(0.3,1,"",0,0,'L');
                $pdf ->Cell("9",1,"_________________________________",0,0,'C');
                $pdf ->Cell("0.5",1,"  ",0,0,'C');
                $pdf ->Cell("9",1,"_________________________________",0,1,'C');
                $pdf->SetY($pdf->GetY() - 0.5);
                $pdf ->Cell("0.3",1,"  ",0,0,'C');
                $pdf ->Cell("9",1,"SOLICITANTE",0,0,'C');
                $pdf ->Cell("0.5",1,"  ",0,0,'C');
                $pdf ->Cell("9",1,"EMPRESA",0,1,'C');
                $pdf ->Cell("",1,"",0,1,'C');
            };
            $i++;

        }
    }
    elseif($funcao == 2){
        $c = 0;
        $b = 0;
        $pdf->AddPage();
        $pdf -> SetFont('Arial','B','13');
        $pdf -> Cell("",2,utf8_decode("RECIBO DE ENTREGA  -  DATA: ".substr($data,0,10)),0,1,'C');
        //comprovante de recebimento tela de cheque e boleto
        while($i < count($titulos)){
            $query = "select financeiro.status,financeiro.id,financeiro.cheque,financeiro.boleto,financeiro.pes_id,financeiro.dt_emi, financeiro.dt_fat,financeiro.dt_baixa, financeiro.apo_id, pessoa.nome as pessoa, pessoa.cpf, empresa.razao as empresa, banco.banco as banco, pagamento.nome as pagamento, centrocusto.nome as centrocusto, natureza.nome as natureza, financeiro.valorbruto, financeiro.valorliquido, financeiro.obs from financeiro,pessoa,empresa,banco,pagamento,centrocusto,natureza where pessoa.id = financeiro.pes_id and empresa.id = financeiro.emp_id and banco.id = financeiro.ban_id and pagamento.id = financeiro.pag_id and centrocusto.id = financeiro.cen_id and natureza.id = financeiro.nat_id  and financeiro.id = '$titulos[$i]'";
            //echo $query;
            $valida = mysqli_query($con,$query);
            if($row = mysqli_fetch_array($valida)){
                if($i == 0) {
                    if (strlen($row['cpf']) == 11) {
                        $cpf = substr($row['cpf'], 0, 3) . "." . substr($row['cpf'], 3, 3) . "." . substr($row['cpf'], 6, 3) . "-" . substr($row['cpf'], 9, 2);
                    } else if (strlen($row['cpf']) == 14) {
                        $cpf = substr($row['cpf'], 0, 2) . "." . substr($row['cpf'], 2, 3) . "." . substr($row['cpf'], 5, 3) . "/" . substr($row['cpf'], 8, 4) . "-" . substr($row['cpf'], 11, 2);
                    } else {
                        $cpf = "CPF / CNPJ INCORRETO NO CADASTRO! FAVOR VERIFICAR!";
                    }
                    $dt_fat = substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4);
                    $pdf->SetFont('Arial', 'B', '12');
                    $pdf->Cell(0.5, 0.5, "", 0, 0, 'L');
                    if($row['cheque'] != ""){
                        $pdf->Cell(5, 0.5, "SEGURADO: ", 0, 0, 'L');
                    }
                    if($row['boleto'] != ""){
                        $pdf->Cell(5, 0.5, "SEGURADORA: ", 0, 0, 'L');
                    }

                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell("", 0.7, strtoupper($row['pes_id'] . " - " . $row['pessoa']), 0, 1, 'L');
                    $pdf->SetFont('Arial', 'B', '11');
                    $pdf->Cell(0.5, 0.7, "", 0, 0, 'L');
                    $pdf->Cell(5, 0.7, "CPF/CNPJ:", 0, 0, 'L');
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell("", 0.7, $cpf, 0, 1, 'L');
                    $pdf->SetFont('Arial', 'B', '11');
                    $pdf->Cell(0.5, 0.7, "", 0, 0, 'L');
                    $pdf->Cell(5, 0.7, "PRODUTOR: ", 0, 0, 'L');
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell("", 0.7, strtoupper($produtor), 0, 1, 'L');
                    $pdf->SetFont('Arial', 'B', '11');
                    $pdf->Cell(0.5, 0.7, "", 0, 0, 'L');
                    $pdf->Cell(5, 0.7, "EMPRESA:", 0, 0, 'L');
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell("", 0.7, $row['empresa'], 0, 1, 'L');
                    $pdf->SetFont('Arial', 'B', '11');
                    $pdf->Cell(0.5, 0.7, "", 0, 0, 'L');
                    $pdf->Cell(5, 0.7, "BANCO:", 0, 0, 'L');
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell("", 0.7, $row['banco'], 0, 1, 'L');
                }
                if($row['cheque'] != ""){
                    if($c == 0){
                        $pdf->SetFont('Arial', 'B', '11');
                        $pdf->Cell(0.5, 0.7, "", 0, 0, 'L');
                        $pdf->Cell(5, 0.7, "FORMA DE PAG.:", 0, 0, 'L');
                        $pdf->SetFont('Arial', '', '11');
                        $pdf->Cell("", 0.7, $row['pagamento'], 0, 1, 'L');
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(0.5, 0.7, "", 0, 0, 'L');
                        $pdf->SetFillColor(26,96,175);
                        $pdf->SetTextColor(245,245,245);
                        $pdf->Cell(2.5, 0.6, utf8_decode("Nº DOC."), 1, 0, 'C',1);
                        $pdf->Cell(2.5, 0.6, utf8_decode("DT.VENC."), 1, 0, 'C',1);
                        $pdf->Cell(10, 0.6, utf8_decode("OBSERVAÇÕES"), 1, 0, 'C',1);
                        $pdf->Cell(3, 0.6, "VALOR", 1, 1, 'C',1);
                        $pdf->SetTextColor(0,0,0);
                    }
                    $pdf->SetFont('Arial', '', '7');
                    $pdf->Cell(0.5, 0.5, "", 0, 0, 'L');
                    $pdf->Cell(2.5, 0.6, $row['cheque'], 1, 0, 'C');
                    $pdf->Cell(2.5, 0.6, substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4), 1, 0, 'C');
                    $pdf->Cell(10, 0.6, $row['obs'], 1, 0, 'C');
                    $pdf->Cell(3, 0.6,"R$ ".number_format( $row['valorliquido'],2,",","."), 1, 1, 'C');
                    $c++;
                    $ctotal += $row['valorliquido'];


                }

                if(($i+1) == count($titulos)){
                    $pdf->Cell("", 0.3, "", 0, 1, 'L');
                    $pdf->Cell(0.5, 1, "", 0, 0, 'L');
                    $pdf->SetFont('Arial', 'B', '11');
                    $pdf->Cell(5, 1, "TOTAL CHEQUE:", 0, 0, 'L');
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell("", 1, "R$ ".number_format($ctotal,2,",","."), 0, 1, 'L');
                }



                if($i == 0){


                }
            };
            $i++;

        }
        $i = 0;
        while($i < count($titulos)){
            $query = "select financeiro.status,financeiro.id,financeiro.cheque,financeiro.boleto,financeiro.pes_id,financeiro.dt_emi, financeiro.dt_fat,financeiro.dt_baixa, financeiro.apo_id, pessoa.nome as pessoa, pessoa.cpf, empresa.razao as empresa, banco.banco as banco, pagamento.nome as pagamento, centrocusto.nome as centrocusto, natureza.nome as natureza, financeiro.valorbruto, financeiro.valorliquido, financeiro.obs from financeiro,pessoa,empresa,banco,pagamento,centrocusto,natureza where pessoa.id = financeiro.pes_id and empresa.id = financeiro.emp_id and banco.id = financeiro.ban_id and pagamento.id = financeiro.pag_id and centrocusto.id = financeiro.cen_id and natureza.id = financeiro.nat_id  and financeiro.id = '$titulos[$i]'";
            //echo $query;
            $valida = mysqli_query($con,$query);
            if($row = mysqli_fetch_array($valida)){
                if($row['boleto'] != ""){
                    if($b ==0){
                        $pdf->SetFont('Arial', 'B', '11');
                        $pdf->Cell(0.5, 0.7, "", 0, 0, 'L');
                        $pdf->Cell(5, 0.7, "FORMA DE PAG.:", 0, 0, 'L');
                        $pdf->SetFont('Arial', '', '11');
                        $pdf->Cell("", 0.7, $row['pagamento'], 0, 1, 'L');
                        $pdf->SetFont('Arial', 'B', '8');
                        $pdf->Cell(0.5, 0.7, "", 0, 0, 'L');
                        $pdf->SetFillColor(26,96,175);
                        $pdf->SetTextColor(245,245,245);
                        $pdf->Cell(2.5, 0.6, utf8_decode("Nº DOC."), 1, 0, 'C',1);
                        $pdf->Cell(2.5, 0.6, utf8_decode("DT.VENC."), 1, 0, 'C',1);
                        $pdf->Cell(10, 0.6, utf8_decode("OBSERVAÇÕES"), 1, 0, 'C',1);
                        $pdf->Cell(3, 0.6, "VALOR", 1, 1, 'C',1);
                        $pdf->SetTextColor(0,0,0);
                    }
                    $pdf->SetFont('Arial', '', '7');
                    $pdf->Cell(0.5, 0.5, "", 0, 0, 'L');
                    $pdf->Cell(2.5, 0.6, $row['boleto'], 1, 0, 'C');
                    $pdf->Cell(2.5, 0.6, substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4), 1, 0, 'C');
                    $pdf->Cell(10, 0.6, $row['obs'], 1, 0, 'C');
                    $pdf->Cell(3, 0.6,"R$ ".number_format( $row['valorliquido'],2,",","."), 1, 1, 'C');
                    $b++;
                    $btotal += $row['valorliquido'];
                }






                if(($i+1) == count($titulos)){
                    $pdf->Cell("", 0.3, "", 0, 1, 'L');
                    $pdf->SetFont('Arial', 'B', '11');
                    $pdf->Cell(0.5, 1, "", 0, 0, 'L');
                    $pdf->Cell(5, 1, "TOTAL BOLETO:", 0, 0, 'L');
                    $pdf->SetFont('Arial', '', '11');
                    $pdf->Cell("", 1, "R$ ".number_format($btotal,2,",","."), 0, 1, 'L');
                }

            };

            $i++;

        }
        $pdf->Cell("", 0.3, "", 0, 1, 'L');
        $pdf->Cell(0.3, 1, "", 0, 0, 'L');
        $pdf ->Cell("18",1,"_________________________________",0,1,'C');
        $pdf ->Cell("18",1,"ASSINATURA",0,1,'C');
    }
    elseif($funcao == 3){
        $banco = $_GET['banco'];
        $select = "select * from banco where id = $banco";
        $val = mysqli_query($con,$select);
        if($r=mysqli_fetch_array($val)){
            $banco = $r['banco'];
            $cod = $r['cod'];
            $agencia = $r['agencia'];
            $conta = $r['conta'];
        }
        $pdf -> AddPage();
        $pdf -> SetFont('Arial','B','13');
        $pdf -> Cell("",1.5,utf8_decode("COMPROVANTE DE BAIXA  -  DATA: ".substr($data,0,10)),0,1,'C');
        $pdf->SetFont('Arial', 'B', '10');
        $pdf -> Cell("",1,utf8_decode("BANCO: ".$cod." - ".$banco."               AGENCIA: ".$agencia."               CONTA: ".$conta),0,1,'C');
        $pdf->SetFillColor(26,96,175);
        $pdf->SetTextColor(245,245,245);
        $pdf->Cell(0.5, 0.5, "", 0, 0, 'L');
        $pdf->Cell(6, 0.7, utf8_decode("NOME"), 1, 0, 'C',1);
        $pdf->Cell(3.5, 0.7, utf8_decode("Nº DOC."), 1, 0, 'C',1);
        $pdf->Cell(2.5, 0.7, utf8_decode("DT.VENC"), 1, 0, 'C',1);
        $pdf->Cell(3.5, 0.7, utf8_decode("DT. BAIXA"), 1, 0, 'C',1);
        $pdf->Cell(2.5, 0.7, "VALOR", 1, 1, 'C',1);
        $pdf->SetTextColor(0,0,0);
        while($i < count($titulos)){
            $query = "select financeiro.cheque, financeiro.status,financeiro.id,financeiro.pes_id,financeiro.dt_emi, financeiro.dt_fat,financeiro.dt_baixa, financeiro.apo_id, pessoa.nome as pessoa, pessoa.cpf, empresa.razao as empresa, banco.banco as banco, pagamento.nome as pagamento, centrocusto.nome as centrocusto, natureza.nome as natureza, financeiro.valorbruto, financeiro.valorliquido, financeiro.obs from financeiro,pessoa,empresa,banco,pagamento,centrocusto,natureza where pessoa.id = financeiro.pes_id and empresa.id = financeiro.emp_id and banco.id = financeiro.ban_id and pagamento.id = financeiro.pag_id and centrocusto.id = financeiro.cen_id and natureza.id = financeiro.nat_id  and financeiro.id = '$titulos[$i]'";
            //echo $query;
            $valida = mysqli_query($con,$query);
            if($row = mysqli_fetch_array($valida)){
                $pdf->SetFont('Arial', '', '7');
                $pdf->Cell(0.5, 0.5, "", 0, 0, 'L');
                $pdf->Cell(6, 0.6, substr($row['pessoa'],0,40), 1, 0, 'C');
                $pdf->Cell(3.5, 0.6, $row['cheque'], 1, 0, 'C');
                $pdf->Cell(2.5, 0.6, substr($row['dt_fat'],8,2)."/".substr($row['dt_fat'],5,2)."/".substr($row['dt_fat'],0,4), 1, 0, 'C');
                $pdf->Cell(3.5, 0.6,date('d/m/Y'), 1, 0, 'C');
                $pdf->Cell(2.5, 0.6,"R$ ".number_format( $row['valorliquido'],2,",","."), 1, 1, 'C');
            };
            $total += $row['valorliquido'];



            if(($i+1) == count($titulos)){
                $pdf->SetFont('Arial', 'B', '12');
                $pdf->Cell(0.5, 2, "", 0, 0, 'L');
                $pdf->Cell(5, 2, "QUANTIA TOTAL:", 0, 0, 'L');
                $pdf->SetFont('Arial', '', '12');
                $pdf->Cell("", 2, "R$ ".number_format($total,2,",","."), 0, 1, 'L');
            }
            $i++;

        }
    }
    elseif($funcao == 4){

    }
    elseif($funcao == 5){

    }
    elseif($funcao == 6){

    }
    elseif($funcao == 7){

    }


$pdf -> Output('Comprovante'.date("d-m-Y").'.pdf','I');
mysqli_close ( $con );
?>
