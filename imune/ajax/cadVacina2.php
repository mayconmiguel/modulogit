<?php $nome = "vacina"; $tabela = "vacina";
require_once "../server/seguranca.php";
?>

<div class="jarviswidget jarviswidget jarviswidget-color-green"  id="novaVacina">

         <header>
             <span class="widget-icon"> <i class="fa fa-table"></i> </span>
             <h2>Cadastro-Vacina</h2>
         </header>
         <div class="widget-body" id="cadVacina>

                 <div class="panel-body col-xs-12">
                     <div class="row">

                         <div class="col-lg-6 col-md-4 col-xs-12">
                             Imunobiologico<input class="form-control" id="vacina" type="text">
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
        </article>
    </div>
    </section>


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
    $("#novaVacina").find("input,textarea,select").each(function(){
        $(this).attr("disabled","disabled");
    });

    //busca campos no banco;
    $.post("server/recupera.php",{tabela:'vacina where id = <?php echo $id;?>'}).done(function(data){
        var obj = JSON.parse(data);


        //alimenta formulário;
        $("#novaVacina").find("#vacina").val(obj[0].vacina);
        $("#novaVacina").find("#nfantasia").val(obj[0].nfantasia);
        $("#novaVacina").find("#laboratorio").val(obj[0].laboratorio);
        $("#novaVacina").find("#indicaçao").val(obj[0].indicaçao);
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
        $("#novaVacina").find("input,textarea,select").each(function(){
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
        $.post("ajax/cadVacina2.php",{id:<?php echo $id;?>}).done(function(data){
            $("#cadastro").empty().html(data);
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
        var data = new FormData();
        $("#novaVacina").find('input:text,select,textarea').each(function(){
            data.append($(this).attr('id'),$(this).val());
        });
        if(vacina.val().length == 0 || vacina.val() == undefined){
            alerta("Aviso!","Favor preencher o campo "+vacina.attr('id')+".","warning","warning");
            vacina.focus().select();
        }
        else{
            var d = new Date();
            var n = d.getTime();
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    //Get upload progress
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //Example showing how to calculate the percent complete
                            console.log(Math.floor((evt.loaded / evt.total * 100)));
                        }
                    }, false);
                    //Get upload progress
                    xhr.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //Example showing how to calculate the percent complete
                            console.log(Math.floor((evt.loaded / evt.total * 100)));
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                async:false,

                //There was no error when sending the image
                success: function(data3){
                    console.log(data3);
                    var img = data3;

                },
                //There was an error when sending the image
                error: function(data) {
                    console.log("error: "+ data);
                }
            });
            $.ajax({
                url: 'server/vacina.php?funcao=2&id='+id,
                data: data,
                async:false,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function ( data2 ) {
                    if (data2.match(/[a-z]/i)) {
                        alerta("Error!",data2,"danger","ban");
                    }else{
                        alerta("Sucesso!","Cadastro realizado com sucesso!","success","check");
                        $.post("ajax/cadVacina2.php",{id:data2}).done(function(data){
                            $("#cadastro").empty().html(data);
                        }).fail(function(){
                            alerta("ERRO!","Função não encontrada!","danger","warning");
                        });
                        try{
                            $("#datatable_col_reorder").dataTable().fnReloadAjax();
                        }
                        catch(e){}
                    }
                }
            });
        }
        });
    </script>
        <script type="text/javascript">
            //oculta tabs

            $("#novaVacina")

            $("#botoesCliente").find("#cadastrar").click(function(){
                var vacina  = $("#novoCliente").find("#vacina");
                var lote  	 = $("#novoCliente").find("#lote");
                var validade = $("#novoCliente").find("#validade");

                var data = new FormData();
                $("#novaVacina").find('input:text,select,textarea').each(function(){
                    data.append($(this).attr('id'),$(this).val());
                });
                if(vacina.val().length == 0 || vacina.val() == undefined){
                    alerta("Aviso!","Favor preencher o campo "+cliente.attr('id')+".","warning","warning");
                    cliente.focus().select();
                }
                else{
                    $.ajax({
                        url: 'server/vacina.php?funcao=1',
                        data: data,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function ( data2 ) {
                            if (data2.match(/[a-z]/i)) {
                                alerta("Error!",data2,"danger","ban");
                            }else{
                                alerta("Sucesso!","Cadastro realizado com sucesso!","success","check");
                                loading("hide");
                                $("#cadastro").dialog('close');

                                try{
                                    $("#datatable_col_reorder").dataTable().fnReloadAjax();
                                }
                                catch(e){}
                                setTimeout(function(){
                                    $("#t_pro").click();
                                },1000);
                            }
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
<script src="js/plugin/avatareffects/js/avatareffects.js"></script>
<script src="js/plugin/avatareffects/js/avatareffects.langs.js"></script>
</script>