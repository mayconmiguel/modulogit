<?php $nome = "vacina"; $tabela = "cartao";
require_once "../server/seguranca.php";
?>

        <div class=" jarviswidget jarviswidget-color-green" id=cadcartaoVacina">

            <header>
                <h2>Carteira De Vacinação - Cadastro</h2>
            </header>
            <div class="widget-body">

                <div class="row">
                    <div class="col-lg-4 col-md-3 col-xs-6">
                        Unidade <select class="form-control" id="unidade">

                        </select>
                    </div>
                    <div class="col-lg-4 col-md-2 col-xs-6">
                        Data Aplicação<input class="form-control" id="dt_aplicacao" type="text">
                    </div>
                    <div class="col-lg-4 col-md-3 col-xs-6">
                        Gr.Atendimento<select class="form-control" id="atendimento">
                            <option>
                                População Geral
                            </option>
                        </select>
                    </div>
                        <div class="col-lg-4 col-md-4 col-xs-6">
                        Estrategia<select class="form-control" id="estrategia">
                                <option>
                                    Serviço Privado
                                </option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-6">
                        Imunobiologico<select class="form-control" id="vacina">
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-6 col-xs-6">
                        tipo<select class="form-control" id="tipo">
                            <option value="adulto">ADULTO</option>
                            <option value="infantil">INFANTIL</option>
                            <option value="infantil">AMBOS</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-2 col-xs-4">
                        Lote<input class="form-control" id="lote" type="text">
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-4">
                        Validade<input class="form-control" id="validade" type="text">
                    </div>
                    <div class="col-lg-1 col-md-1 col-xs-4">
                        Dose<select class="form-control" id="dose">
                            <option value="dose">1</option>
                            <option value="dose">2</option>
                            <option value="dose">3</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-2 col-xs-6">
                        Data Retorno<input class="form-control" id="dt_retorno" type="text">
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-6">
                        Valor<input class="form-control" value="R$:" id="valor" type="text">
                    </div>
                    <div class="col-lg-1 col-md-1 col-xs-6">
                        Desconto<select class="form-control" id="desconto">
                            <option value="desconto">NÃO</option>
                            <option value="desconto">SIM</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-xs-6">
                        Valor desconto<input class="form-control" value="R$:" id="vdesconto">
                    </div>
                    <div class="col-lg-3 col-md-3 col-xs-7">
                        Forma Pagamento<select class="form-control" id="formapagamento">
                            <option value="dinheiro">DINHEIRO</option>
                            <option value="cartao">CARTÃO CRÉDITO</option>
                            <option value="cartao">CARTÃO DÉBITO</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-3 col-xs-6">
                        Parcela<select class="form-control" id="parcela">
                            <option value="parcelas">1</option>
                            <option value="parcelas">2</option>
                            <option value="parcelas">3</option>
                            <option value="parcelas">4</option>
                            <option value="parcelas">5</option>
                            <option value="parcelas">6</option>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-3 col-md-3 col-xs-6">
                        Aplicador:<select class="form-control" id="aplicador">
                        </select>
                    </div>

                    <div class="col-lg-1 col-md-3 col-xs-6">
                        Domicilio<select class="form-control" id="domicilio">
                            <option value="domicilio">SIM</option>
                            <option value="domicilio">NAO</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-lg-push-1 col-md-3 col-xs-6">
                        Estoque Minimo<input class="form-control" id="estoquemin" type="text">
                    </div>
                    <div class="col-lg-2 col-md-3 col-lg-push-2 col-xs-6">
                        Estoque Atual<input class="form-control" id="estoqueatual" type="text">
                    </div>
                </div>
                <div class="row" id="botoesCliente">
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
                        $("#novaVacina").find("#unidade").val(obj[0].unidade);
                        $("#novaVacina").find("#dt_aplicacao").val(obj[0].dt_aplicacap);
                        $("#novaVacina").find("#atendimento").val(obj[0].atendimento);
                        $("#novaVacina").find("#laboratorio").val(obj[0].estrategia);
                        $("#novaVacina").find("#vacina").val(obj[0].vacina);
                        $("#novaVacina").find("#tipo").val(obj[0].tipo);
                        $("#novaVacina").find("#lote").val(obj[0].lote);
                        $("#novaVacina").find("#validade").val(obj[0].validade);
                        $("#novaVacina").find("#dose").val(obj[0].dose);
                        $("#novaVacina").find("#dt_retorno").val(obj[0].dt_retorno);
                        $("#novaVacina").find("#valor").val(obj[0].valor);
                        $("#novaVacina").find("#desconto").val(obj[0].desconto);
                        $("#novaVacina").find("#vdesconto").val(obj[0].vdesconto);
                        $("#novaVacina").find("#formapagamento").val(obj[0].formapagamento);
                        $("#novaVacina").find("#parcela").val(obj[0].parcela);
                        $("#novaVacina").find("#aplicador").val(obj[0].aplicador);
                        $("#novaVacina").find("#domicilio").val(obj[0].domicilio);
                        $("#novaVacina").find("#estoquemin").val(obj[0].estoquemin);
                        $("#novaVacina").find("#estoqueatual").val(obj[0].estoqueatual);


                    });

                    //editando formulário
                    $("#editar").click(function(){
                        //Liberar campos pra edição
                        $("#novo<?php echo $tabela;?>").find("input,textarea,select").each(function(){
                            $(this).removeAttrs("disabled");
                        });

                        //focar no primeiro campo
                        $("#nome").focus().select();

                        //esconde botões
                        $("#excluir,#editar").addClass("hidden");

                        //aparece botões
                        $("#salvar,#cancelar").removeClass("hidden");
                    });

                    //excluindo item


                    // cancelando edição
                    $("#cancelar").click(function(){
                        $.post("ajax/cadcartaoVacina.php",{id:<?php echo $id;?>}).done(function(data){
                            $("#cadastrar").empty().html(data);
                        }).fail(function(){
                            alerta("ERRO!","Função não encontrada!","danger","warning");
                        });
                    });

                    //salvando edição

                </script>
            <?php
            }else{
            ?>
                <script type="text/javascript">
                    $("input[name='tipo[]']").each(function(){
                        $(this).attr('checked',true);
                    });
                    //inserir cadastro
                    $("#cadastrar").click(function(){
                        var nome 		= $("#nome").val();

                        if(nome==="")
                        {

                            alerta("AVISO!","Favor preencher o campo Imunobiologico!","warning","warning");
                            focar($("#nome"));
                        }

                        else
                        {
                            var data = new FormData();
                            $("#novaVacina").find('input:text,select,textarea').each(function(){
                                data.append($(this).attr('id'),$(this).val());
                            });
                            data.append("funcao",1);

                            loading("show");
                            $.ajax({
                                url: 'server/cartao.php',
                                type: 'POST',
                                processData: false,
                                contentType: false,
                                cache: false,
                                data:data,
                                success: function(data) {
                                    if(data == 2){
                                        alerta("AVISO!","Já existe uma <?php echo $nome;?> com o mesmo nome cadastrado no sistema!","warning","warning");
                                        focar($("#nome"));
                                        loading('hide');
                                    }else if(data == 1){
                                        alerta("SUCESSO!","<?php echo $nome;?> cadastrado com sucesso!","success","check");
                                        $("#cadastrar").dialog('close');
                                        $.ajax({
                                            url: 'ajax/cartaoVacina.php',
                                            type: 'POST',
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
                                        $("#cadastrar").dialog('close');
                                    }
                                    loading("hide");
                                }
                            });
                        }
                    });


                </script>
                <?php
            }

            ?>


            <script type="text/javascript">


                $("#validade").datepicker({


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

                $("#dt_aplicacao").datepicker({


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
                $("#dt_retorno").datepicker({

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


                $("#esquema").select2();
                $("#valor").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});
                $("#valordesconto").maskMoney({thousands:'', decimal:',', affixesStay: false,suffix:' %'});



                loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
                    loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
                        loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
                            loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
                                loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
                            });
                        });
                    });
                });

            </script>

