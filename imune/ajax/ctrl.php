<script type="text/javascript">

    //inserir cadastro
    $("#cadastrar").click(function(){
        var nome  	         = $("#nome").val();
        var nfantasia        = $("#nfantasia").val();
        var id   	         = $("#id").attr("cod");
        var laboratorio      = $("#laboratorio").val();
        var imunologico      = $("#imunologico").val();
        var indicaçao        = $("#indicaçao").val();
        var datafabricaçao 	 = $("#datafabricaçao").val();
        var validade  	     = $("#validade").val();
        var lote             = $("#lote").val();
        var quantidade       = $("#quantidade").val();
        var estoqueminimo    = $("#estoqueminimo").val();
        var estoqueatual     = $("#estoqueatual").val();
        var dose             = $("#dose").val();
        var esquemadose      = $("#esquemadose").val();
        var datacompra       = $("#datacompra").val();
        var nfiscal          = $("#nfiscal").val();
        var valornfiscal     = $("#valornfiscal").val();
        var valor            = $("#valor").val();
        var desconto         = $("#desconto").val();
        var descriçao        = $("#descriçao").val();


        var bancos = [];
        $("#bancos option:selected").each(function(){
            bancos.push($(this).val());
        });
        if(nome==="")
        {
            alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
            focar($("#nome"));
        }
        else
        {
            loading("show");
            $.ajax({
                url: 'server/vacinas.php',
                type: 'POST',
                cache: false,
                data:nameList,
                success: function(data) {
                    if(data == 2){
                        alerta("AVISO!","Já existe um <?php echo $nome;?> com o mesmo cnpj cadastrado no sistema!","warning","warning");
                        focar($("#nome"));
                        loading('hide');
                    }else if(data == 1){
                        alerta("SUCESSO!","<?php echo $nome;?> cadastrado com sucesso!","success","check");
                        $("#cadastro").dialog('close');
                        $.ajax({
                            url: 'ajax/<?php echo $tabela;?>.php',
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
        $("#cadastrar").click(function(){
            envia();
        });
    });
    type="text/javascript">
        pageSetUp();


    $("#cadastrar").click(function(){
        envia();
    });
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














$("#novaVacina").find("#registro").val(obj[0].registro);
$("#novaVacina").find("#nome").val(obj[0].nome);
$("#novaVacina").find("#nome").val(obj[0].nome);
$("#novaVacina").find("#nfantasia").val(obj[0].nfantasia);
$("#novaVacina").find("#laboratorio").val(obj[0].laboratorio);
$("#novaVacina").find("#imunologico").val(obj[0].imunologico);
$("#novaVacina").find("#indicaçao").val(obj[0].indicaçao);
$("#novaVacina").find("#datafabricaçao").val(obj[0].datafabricaçao);
$("#novaVacina").find("#validade").val(obj[0].validade);
$("#novaVacina").find("#lote").val(obj[0].lote);
$("#novaVacina").find("#quantidade").val(obj[0].quantidade);
$("#novaVacina").find("#estoqueminimo").val(obj[0].estoqueminimo);
$("#novaVacina").find("#estoqueatual").val(obj[0].estoqueatual);
$("#novaVacina").find("#dose").val(obj[0].dose);
$("#novaVacina").find("#esquemadose").val(obj[0].esquemadose);
$("#novaVacina").find("#datacompra").val(obj[0].datacompra);
$("#novaVacina").find("#nfiscal").val(obj[0].nfiscal);
$("#novaVacina").find("#valornfiscal").val(obj[0].valornfiscal);
$("#novaVacina").find("#valor").val(obj[0].valor);
$("#novaVacina").find("#desconto").val(obj[0].desconto);
$("#novaVacina").find("#descriçao").val(obj[0].descriçao);










$("#cadastrar").click(function(){
var registro         =$("#registro").val();
var nome             =$("#nome").val();
var nome             =$("#nome").val();
var nfantasia        =$("#nfantasia").val();
var laboratorio      =$("#laboratorio").val();
var imunologico      =$("#imunologico").val();
var indicaçao        =$("#indicaçao").val();
var datafabricaçao   =$("#datafabricaçao").val();
var validade         =$("#validade").val();
var lote             =$("#lote").val();
var quantidade       =$("#quantidade").val();
var estoqueminimo    =$("#estoqueminimo").val();
var estoqueatual     =$("#estoqueatual").val();
var dose             =$("#dose").val();
var esquemadose      =$("#esquemadose").val();
var datacompra       =$("#datacompra").val();
var nfiscal          =$("#nfiscal").val();
var valornfiscal     =$("#valornfiscal").val();
var valor            =$("#valor").val();
var desconto         =$("#desconto").val();
var descriçao        =$("#descriçao").val();

if(nome==="")
{
alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
focar($("#nome"));
}
else if(laboratorio ===""){
alerta("AVISO!","Favor preencher o campo Laboratorio!","warning","warning");
focar($("#laboratorio"));
}
else
{
loading("show");
$.ajax({
url: 'server/vacinas.php',
type: 'POST',
data: {funcao:2,registro:registro,nome:nome,nfantasia:nfantasia,laboratorio:laboratorio,imunologico:imunologico,indicaçao:indicaçao,datafabricaçao:datafabricaçao,validade:validade},
success: function(data) {
if(data == 1){
alerta("AVISO!","Já existe um com o mesmo nome cadastrado no sistema!","warning","warning");
focar($("#nome"));
loading('hide');
}else if(data == 1){
alerta("SUCESSO!"," cadastrado com sucesso!","success","check");
$("#cadastro").dialog('close');
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
alerta("ERRO!","Erro ao cadastrar nome!","danger","ban");
$("#cadastro").dialog('close');
}
loading("hide");
}
});
}
});
