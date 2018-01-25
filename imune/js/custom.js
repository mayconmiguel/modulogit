function confirma(a,b,c){
    $.SmartMessageBox({
        title : a,
        content : b,
        buttons : '[NÃO][SIM]'
    }, function(ButtonPressed) {
        if (ButtonPressed === "SIM") {
            c();
        }
        if (ButtonPressed === "NÃO") {
        }
    });
}

function alerta(a,b,c,d){
    var cor = "#000000";
    if(c == "danger"){
        cor = "#C46A69";
    }else if(c == "info"){
        cor = "#3276B1";
    }else if(c == "warning"){
        cor = "#C79121";
    }else if (c == "success"){
        cor = "#739E73";
    }
    $.bigBox({
        title : a,
        content : b,
        color : cor,
        //timeout: 6000,
        icon : "fa fa-"+d+" shake animated",
        timeout : 6000
    });
}

function limpa(a){
    $(a).empty().hide();
}

function focar(a){
    $(a).focus().select();
    $(a).val('');
}

function loading(a){
    if (a == "show"){
        $("#loading").fadeIn(500);
    }
    else if(a == "hide"){
        $("#loading").fadeOut(500);
    }
}

function logout(){
    loading("show");
    $.post("logout.php").done(function(data){
        $("#dados").html(data);
        loading("hide");
    });
}

function link(a){
    loading("show");
    $("#side > li").removeClass('active');
    $(this).addClass('active');
    $.post(a).done(function(data){
        $("#conteudo").empty().html(data);
        loading("hide");
    }).fail(function(){
        alerta("ERRO!","Função não encontrada!","danger","ban");
        loading("hide");
    });
}

function controleCol(a,b,c){

    $.post("server/controleCol.php",{a:a,b:b,c:c}).done(function (data){
        $("#dados").val(data);
    });

}

function buscaNomePorID(a,b,c,d){
    $.post(a,{id:b,funcao:c,div:d}).done(function(data){
        $(d).html(data);
    }).fail(function(){
        alerta("ERRO!","Não foi possível executar esta operação","danger","ban");
    });
}

function bloquear(){
    alerta("ACESSO NEGADO!","Você não tem permissão para acessar esta área!<br>Você será redirecionado para outra área.","danger","ban");
    loading("show");
    setTimeout(function(){
        $.post("cadastroClientes.php").done(function(data){
            $("#conteudo").empty().html(data);
            loading("hide");
        });
    },1000);
}

function tabenter(a,b){
    $(a).keydown(function(e){
        if(e.keyCode == 13)
        {
            var inputs = $(this).parents(b).eq(0).find(":input:enabled, select:enabled");
            var idx = inputs.index(this);
            if (idx == inputs.length - 1) {
                inputs[0].select()
            } else {
                inputs[idx + 1].focus(); //  handles submit buttons
                inputs[idx + 1].select();
            }
            return false;
        }
    });
}

function dataAtualFormatada(){
    var data = new Date();
    var dia = data.getDate();
    if (dia.toString().length == 1)
        dia = "0"+dia;
    var mes = data.getMonth()+1;
    if (mes.toString().length == 1)
        mes = "0"+mes;
    var ano = data.getFullYear();
    return dia+"/"+mes+"/"+ano;
}

function encode_utf8(s) {
    return unescape(encodeURIComponent(s));
}

function decode_utf8(s) {
    return decodeURIComponent(escape(s));
}

function cep(a){
    $(a).keyup(function(){
        if(($(this).val().length == 9) && ($(this).val().indexOf('_') <= -1))
        {
            loading("show");
            $.get("http://viacep.com.br/ws/"+$(this).val()+"/json/").done(function(data){
                $("#endereco").val(data.logradouro);
                $("#bairro").val(data.bairro);
                $("#cidade").val(data.localidade);
                $("#estado").val(data.uf);
                $("#loading").fadeOut(500);
                $("#numero").focus();
            }).fail(function(){
                $("#endereco").val('');
                $("#bairro").val('');
                $("#cidade").val('');
                $("#estado").val('');
                $("#loading").fadeOut(500);
                $("#cep").focus();
                loading("hide");
            });
        };
    });
}

function numero(a){
    $(a).keyup(function(e){
        var val = $(this).val();
        val = val.replace(/[^0-9\,.]/g,'');

        val = val.replace(/\,+$/,".");

        if(val.split('.').length>2)
        {
            val =val.replace(/\.+$/,".");
        }

        $(this).val(val);
    });
}

function condicao(a){
    $(a).keyup(function(e){
        var val = $(this).val();
        val = val.replace(/[^0-9\,-]/g,'');

        val = val.replace(/\,+$/,"-");

        if(val.split('-').length>2)
        {
            val =val.replace(/\-+$/,"-");
        }

        $(this).val(val);
    });
}

function comprovante(a,b){
    window.open(a + "?" + b, "_blank");
}

//mascaras
var options =  {onKeyPress: function(cep, e, field, options){
    var masks = ['000.000.000-000', '00.000.000/0000-00'];
    mask = (cep.length>14) ? masks[1] : masks[0];
    $("input[id='cpf']").mask(mask, options);
}};
$("input[id='cpf']").mask('000.000.000-00',options);
$('input[id="cnpj"]').mask('00.000.000/0000-00');
$('input[id="rg"]').mask("000.000.000",{reverse:true});
$('input[id="nasc"]').mask("00/00/0000");
$('input[id="cep"]').mask("00000-000");

$('input[id="saldo"]').mask("0000000000.00",{reverse:true});



$('input[id="placa"]').mask("AAA-0000");
$('input[id="parc"],input[id="qtd_parcela"]').mask('00');

var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };
$('input[id="telefone"]').mask(SPMaskBehavior, spOptions);
$('input[id="celular"]').mask(SPMaskBehavior, spOptions);



// register jQuery extension
jQuery.extend(jQuery.expr[':'], {
    focusable: function (el, index, selector) {
        return $(el).is('a, button, :input, [tabindex]');
    }
});

$(document).on('keypress', 'input:enabled,select:enabled', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':enabled:focusable:not(:radio):not(:checkbox)');
        var index = $canfocus.index(this) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});

function auditoria(a,b,c,d){
    $.post('server/auditoria.php');
}

function seguradora(a){
    $.post("server/recupera.php",{tabela:'pessoa where seg = 1'}).done(function(data){
        var obj = JSON.parse(data);
        for(i in obj){
            $(a).find("#seguradora").append('<option valor="'+obj[i].comissao+'" value="'+obj[i].id+'">'+obj[i].nome.toUpperCase()+'</option>');
        }
    });
}
function empresaBanco(a,d,c){
    $.post("server/recupera.php",{tabela:'empresa where grp_emp_id = '+d+' and tipo = 1'}).done(function(data){
        var obj = JSON.parse(data);
        for(o in obj){
            if(o == 0){
                $(a).find("#empresa").empty().append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
                var banco2 = obj[o].bancos.split(',');
                var ban = "(";
                for(b in banco2){
                    ban += 'id = '+banco2[b]+' or ';
                };
                ban = ban.substr(0,ban.length-4);
                ban = ban + ')';

                if(c){
                    ban += " order by id desc";
                }
                $.post("server/recupera.php",{tabela:'banco where '+ban}).done(function(data2){
                    var obj2 = JSON.parse(data2);
                    for(o2 in obj2){
                        if(o2 == 0){
                            $(a).find("#banco").empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
                            $(a).find("#bx_banco").empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

                        }else{
                            $(a).find("#banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
                            $(a).find("#bx_banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

                        }
                    }
                }).fail(function(){

                });
            }else{
                $(a).find("#empresa").append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
            }
        }
    }).fail(function(){

    });

    $(a).find("#empresa").change(function(){
        var banco2 = $(a).find("#empresa option:selected").attr('bancos').split(',');
        var ban = "(";
        for(b in banco2){
            ban += 'id = '+banco2[b]+' or ';
        };
        ban = ban.substr(0,ban.length-4);
        ban = ban + ')';
        $.post("server/recupera.php",{tabela:'banco where '+ban}).done(function(data2){
            var obj2 = JSON.parse(data2);
            for(o2 in obj2){
                if(o2 == 0){
                    $(a).find("#banco").empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

                }else{
                    $(a).find("#banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

                }
            }
        }).fail(function(){

        });
    });
}

function envia(url,data){
    $.ajax
    ({
        type: "POST",
        url: url,
        async: false,
        headers: {
            "Authorization": "Basic " + btoa("imunevacinas:THMPV-77D6F-94376-8HGKG-VRDRQ")
        },
        data: data,
        success: function (data, textStatus, request){
            if(data == 1){
                alerta("Sucesso!","Solicitação realizada com sucesso!","success","check");
                try{
                    $("#cadastro").dialog('close');
                }catch(e){

                }
            }else{
                alerta("Falha ao inserir um interessado","","danger","ban");
            }
            try{
                $("#datatable_col_reorder").dataTable().fnReloadAjax();
            }
            catch(e){

            };
            loading('hide');
        },
        error:function(){
            alerta("Falha na solicitação","","danger","ban");
            loading('hide');
        }
    });
}

function sucesso(){
    alerta("Sucesso!","Operação realizada com sucesso!",'success','check');
}

function erro(){
    alerta("Erro!","Não foi possível realizar esta operação!",'danger','ban');
}


function enviaSMS(a){
    $.ajax({
        url: 'server/campanhaSMS.php',
        type: 'POST',
        cache: false,
        async: true,
        data:a,
        success: function(data) {
            console.log(data);
        },
        error:function(e){
            console.log(e);
        }
    });
}





function saldoSMS(){
    $.ajax({
        url: 'server/saldoSMS.php',
        type: 'GET',
        cache: false,
        async: true,
        success: function(data) {
            var obj = JSON.parse(data);

            if(obj.balance){
                var saldo = (parseInt(obj.balance)/0.10);
                $("#nav_saldo_sms").html(saldo);
            }else{
                var saldo = (parseInt(obj.data));
                $("#nav_saldo_sms").html(saldo);
            }
        },
        error:function(){

        }
    });
}

function sms(a){
    $.ajax({
        url: 'server/SMS.php',
        type: 'GET',
        cache: false,
        async: true,
        data:a,
        success: function(data) {
            console.log(data);
        },
        error:function(){

        }
    });
}

function maiuscula(z){
    v = z.value.toUpperCase();
    z.value = v;
}

function mai(){
    $('input[type!=password][id!=email],textarea[id!=txt2]').keyup(function(){
        maiuscula(this);
    });
}