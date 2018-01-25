<?php $nome = "vacina"; $tabela = "retorno";
require_once "../server/seguranca.php";
?>

<div class="jarviswidget jarviswidget-color-green" id=cadRetorno">

        <header>
            <h2>Retorno</h2>
        </header>
        <div>
            <div class="widget-body">

                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                            Nome<select class="form-control" id="aplicador">
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                            Data Nascimento<input class="form-control" id="nasc" type="text">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            Estrategia<select class="form-control" id="aplicador">
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            Imunobiologico<select class="form-control" id="tipo">
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                            Dose<select class="form-control" id="dose">
                                <option value="dose">1</option>
                                <option value="dose">2</option>
                                <option value="dose">3</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
                            Data Retorno<input class="form-control" id="dtretorno" type="text">
                        </div>
                    </div>
              </div>
                <div class="row" id="botoes">
                    <div class="col-sm-12 center">
                        <a href="javascript:void(0);" type="submit" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i                               class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
                        <a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i                                         class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
                        <a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i                                            class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
                        <a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i                                        class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
                        <a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden "> <span class="btn-label"><i                                        class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
                        <a href="javascript:void(0);" id="salvar" class="btn btn-md btn-primary hidden"> <span class="btn-label"><i                                         class="glyphicon glyphicon-floppy-disk"></i></span>Salvar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

    if(isset($_POST['id'])){
        $id = $_POST['id'];
        ?>
        <script>
            //mostra botões ocultos;
            $("#editar, #excluir").removeClass("hidden");

            //oculta botões;
            $("#cadastrar").addClass("hidden");

            //bloqueia campos;
            // desabilita todos campos de entrada
            $("#novo<?php echo $tabela;?>").find("input,textarea,select").each(function(){
                $(this).attr("disabled","disabled");
            });

            //busca campos no banco;
            $.post("server/recupera.php",{tabela:'cartao where id = <?php echo $id;?>'}).done(function(data){
                var obj = JSON.parse(data);


                //alimenta formulário;
                $("#novaVacina").find("#estacaosaude").val(obj[0].estacaosaude);
                $("#novaVacina").find("#dataaplicaçao").val(obj[0].dataaplicaçao);
                $("#novaVacina").find("#atendimento").val(obj[0].atendimento);
                $("#novaVacina").find("#laboratorio").val(obj[0].estrategia);
                $("#novaVacina").find("#imunologico").val(obj[0].imunologico);
                $("#novaVacina").find("#tipo").val(obj[0].tipo);
                $("#novaVacina").find("#lote").val(obj[0].lote);
                $("#novaVacina").find("#validade").val(obj[0].validade);
                $("#novaVacina").find("#dose").val(obj[0].dose);
                $("#novaVacina").find("#dataretorno").val(obj[0].dataretorno);
                $("#novaVacina").find("#valor").val(obj[0].valor);
                $("#novaVacina").find("#desconto").val(obj[0].desconto);
                $("#novaVacina").find("#vdesconto").val(obj[0].vdesconto);
                $("#novaVacina").find("#formapagamento").val(obj[0].formapagamento);
                $("#novaVacina").find("#parcela").val(obj[0].parcela);
                $("#novaVacina").find("#aplicador").val(obj[0].aplicador);
                $("#novaVacina").find("#domicilio").val(obj[0].domicilio);
                $("#novaVacina").find("#estoqueminimo").val(obj[0].estoqueminimo);
                $("#novaVacina").find("#estoqueatual").val(obj[0].estoqueatual);


            });
        </script>
        <?php
    }else{
        ?>
        <script type="text/javascript">

            $("#nasc").datepicker({

                changeMonth: true,
                numberOfMonths: 1,
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                language: 'pt-BR',
                dateFormat: 'dd/mm/yy',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                    'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                onClose: function (selectedDate) {

                }

            }).val("<?php echo date('01/m/Y');?>");
            $("#dtretorno").datepicker({
                
                changeMonth: true,
                numberOfMonths: 1,
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                language: 'pt-BR',
                dateFormat: 'dd/mm/yy',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                    'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                    'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                onClose: function (selectedDate) {

                }
            }).val("<?php echo date('t/m/Y');?>");


            $("input[name='tipo[]']").each(function(){
                $(this).attr('checked',true);
            });
            //inserir cadastro
            $("#cadastrar").click(function(){
                var nome 		= $("#nome").val();

                if(nome==="")
                {
                    alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
                    focar($("#nome"));
                }

                else
                {
                    loading("show");
                    $.ajax({
                        url: '',
                        type: 'GET',
                        cache: false,
                        data: {nome:nome},
                        success: function(data) {
                            if(data == 2){
                                alerta("AVISO!","Já existe uma <?php echo $nome;?> com o mesmo nome cadastrado no sistema!","warning","warning");
                                focar($("#nome"));
                                loading('hide');
                            }else if(data == 1){
                                alerta("SUCESSO!","<?php echo $nome;?> cadastrado com sucesso!","success","check");
                                $("#cadastro").dialog('close');
                                $.ajax({
                                    url: 'ajax/cadcartaoVacina.php',
                                    type: 'GET',
                                    cache: false,
                                    success: function(data) {
                                        $("#content").html(data);
                                    },
                                    error:function(){
                                        loading('hide');
                                    }
                                });
                            }else if(data == 0){
                                alerta("ERRO!","Erro ao cadastrar <?php echo $nome;?>!","danger","ban");
                                $("#cadastro").dialog('close');
                            }
                            loading("hide");
                        }
                    });
                }
            });
            $("#cadastrar").click(function(){
                envia();
            });
        </script>
        <?php
    }

    ?>

