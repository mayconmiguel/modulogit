<?php $nome = "vacina"; $tabela = "vacinas";
require_once "../server/seguranca.php";
?>

<div class="jarviswidget jarviswidget jarviswidget-color-green"  id="novaVacina">

    <header>
        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
        <h2>Cadastro-Vacina</h2>
    </header>
    <div class="widget-body id="cadVacina"">

    <div class="panel-body col-xs-12">
        <div class="row">

            <div class="col-lg-6 col-md-4 col-xs-12">
                Imunobiologico<input class="form-control" id="nome" type="text">
            </div>
            <div class="col-lg-6 col-md-4 col-xs-12">
                Nome fantasia<input class="form-control" id="nfantasia" type="text">
            </div>
            <div class="col-lg-2 col-md-4 col-xs-5">
                Laboratorio<input class="form-control" id="laboratorio" type="text">
            </div>
            <div class="col-lg-4 col-md-4 col-xs12">
                Indicação<select class="form-control" id="indicacao">
                </select>
            </div>
            <div class="col-lg-3 col-md-4 col-xs-7">
                Data Fabricação<input class="form-control" id="dt_fabricacao" type="text">
            </div>
            <div class="col-lg-3 col-md-4 col-xs-6">
                Lote<input class="form-control" id="lote" type="text">
            </div>
            <div class="col-lg-3 col-md-4 col-xs-6">
                Validade<input class="form-control" id="vencimento" type="text">
            </div>
            <div class="col-lg-2 col-md-4 col-xs-6">
                Quantidade<input class="form-control" id="quantidade" type="text">
            </div>
            <div class="col-lg-2 col-md-4 col-xs-6">
                Dose<select class="form-control" id="dose">
                </select>
            </div>
            <div class="col-lg-3 col-md-4 col-xs-6">
                Esquema de Doses
                <select class="select-multiple"multiple style="width:100%;"  name="esquema" id="esquema">
                    <?php

                    for($i=0;$i<=720;$i++){
                        ?>
                        <option value="<?php echo $i;?>"><?php echo $i." DIAS";?></option>
                        <?php
                    }

                    ?>
                </select>
            </div>
            <div class="col-lg-1 col-md-4 col-xs-12">
                Estoque Min<input class="form-control"  id="estoquemin" type="text">
            </div>
            <div class="col-lg-1 col-md-4 col-xs-12">
                Estoque Atual<input class="form-control" id="estoqueatual" type="text">
            </div>
        </div>
        <div class="row">

            <div class="row">
                <div class="col-lg-12 col-md-4  col-md-puscol-xs-12">
                    Descrição Vacina
                    <textarea class="form-control" name="obs" id="descricao"></textarea>
                </div>
            </div>


            <br>
            <div class="row" id="botoesCliente">
                <div class="col-sm-12 center">
                    <a href="javascript:void(0);" type="submit" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
                    <a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
                    <a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
                    <a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
                    <a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden "> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
                    <a href="javascript:void(0);" id="salvar" class="btn btn-md btn-primary hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>Salvar</a>
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
        $.post("server/recupera.php",{tabela:'vacina where id = <?php echo $id;?>'}).done(function(data){
            var obj = JSON.parse(data);


            //alimenta formulário;
            $("#novaVacina").find("#nome").val(obj[0].nome);
            $("#novaVacina").find("#nfantasia").val(obj[0].nfantasia);
            $("#novaVacina").find("#laboratorio").val(obj[0].laboratorio);
            $("#novaVacina").find("#indicacao").val(obj[0].indicacao);
            $("#novaVacina").find("#dt_fabricacao").val(obj[0].dt_fabricacao);
            $("#novaVacina").find("#vencimento").val(obj[0].vencimento);
            $("#novaVacina").find("#lote").val(obj[0].lote);
            $("#novaVacina").find("#quantidade").val(obj[0].quantidade);
            $("#novaVacina").find("#estoqueminimo").val(obj[0].estoquemin);
            $("#novaVacina").find("#estoqueatual").val(obj[0].estoqueatual);
            $("#novaVacina").find("#dose").val(obj[0].dose);
            $("#novaVacina").find("#esquema").val(obj[0].esquema);
            $("#novaVacina").find("#descricao").val(obj[0].descricao);

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
            $.post("ajax/cadvacina.php",{id:<?php echo $id;?>}).done(function(data){
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
                    url: 'server/vacinas.php',
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
                                url: 'ajax/vacinas.php',
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

    $("#dt_fabricacao").datepicker({


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
    $("#vencimento").datepicker({

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