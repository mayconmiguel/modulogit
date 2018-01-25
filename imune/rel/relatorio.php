<?php
    require_once "../server/seguranca.php";
    $empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>
<section id="widget-grid-cliente" class="well">
    <form action="rel/relFinanceiro.php" method="post" target="_blank" id="rel-form" class="smart-form client-form">
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 text-align-right">

            </div>
            <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
                <h2>RELATÓRIO</h2>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 text-align-right">

            </div>
            <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
                <div class="form-group">
                    <label for="form-field-select-3">SELECIONE UM TIPO:</label>
                    <div>
                        <select class="form-control"  style="width: 100%;" id="tipo" name="tipo">
                            <option value="1">CONTAS À PAGAR</option>
                            <option value="2">CONTAS À RECEBER</option>
                            <option value="3">CONTAS PAGAS</option>
                            <option value="4">CONTAS RECEBIDAS</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>
        <div class="row" style="padding-top:-30px">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 align-right">

            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-5">
                <label class="input"> Data Inicial
                    <input id="from" name="from" style="width:99%;">
                    <b class="tooltip tooltip-top-right"> Por favor, informe uma data inicial!</b></label>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-5">
                <label class="input">Data Final
                    <input id="to"  name="to"  style="width:98%;margin-left:2%">
                    <b class="tooltip tooltip-top-right">Por favor, informe uma data final!</b> </label>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>




        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 text-align-right">

            </div>
            <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
                AGRUPAR POR:
                <div class="inline-group">
                    <label class="radio">
                        <input name="group" type="radio" value="1">
                        <i></i>
                        DATA
                    </label>
                    <label class="radio">
                        <input name="group" type="radio" value="7">
                        <i></i>
                        PESSOA
                    </label>
                    <label class="radio">
                        <input name="group" checked="checked" type="radio" value="2">
                        <i></i>
                        EMPRESA
                    </label>
                    <label class="radio">
                        <input name="group" type="radio" value="3">
                        <i></i>
                        BANCO
                    </label>
                    <label class="radio">
                        <input name="group" type="radio" value="4">
                        <i></i>
                        CENTRO DE CUSTO
                    </label>
                    <label class="radio">
                        <input name="group" type="radio" value="5">
                        <i></i>
                        NATUREZA FINANCEIRA
                    </label>
                    <label class="radio">
                        <input name="group" type="radio" value="6">
                        <i></i>
                        FORMA DE PAGAMENTO
                    </label>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
            <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
                <button type="submit" class="btn btn-primary dark btn-block" style="height: 35px;">Gerar Relatório</button>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>
    </form>
</section>
<script>
    $("#cadastro").hide();
    $('input[id="pessoa"]').autocomplete({
        source: "ajax/busca.php",
        minLength:3,
        delay:500,
        select: function(event,ui){
            $('input[id="retorno"]').val(ui.item.id);
            $('input[id="pessoa"]').attr("value",ui.item.nome);
        },
        search: function(){
            loading('show');
        },
        response: function(){
            loading("hide");
        }
    });
    var banco = '(';
    $("#widget-grid-cliente").find("#tipo").select2();
    $("#widget-grid-cliente").find('input[name="checkbox_empresa"]').change(function(){
        if(this.checked){
            $("#widget-grid-cliente").find('#empresa').removeAttr('disabled');
        }else{
            $("#widget-grid-cliente").find('#empresa').attr('disabled',true);
            $("#widget-grid-cliente").find("#empresa").select2('val','');
            $("#widget-grid-cliente").find("#empresa option").removeAttrs('selected');
            if($("#widget-grid-cliente").find("input[name='checkbox_banco']:checked").length == 1){
                $.post('server/recupera.php',{tabela:"banco"}).done(function(data){
                    var obj2 = JSON.parse(data);
                    for(o in obj2){
                        if(o == 0){
                            $("#widget-grid-cliente").find("#banco").empty().append('<option value="'+obj2[o].id+'">'+obj2[o].banco+'</option>');
                        }
                        else{
                            $("#widget-grid-cliente").find("#banco").append('<option value="'+obj2[o].id+'">'+obj2[o].banco+'</option>');
                        }
                    }
                    banco = '(';
                }).fail(function(){
                    banco = '(';
                });
            }
        }
    });

    $("#widget-grid-cliente").find('input[name="checkbox_banco"]').change(function(){
        if(this.checked){
            if($("#widget-grid-cliente").find("#empresa option:selected").length >0){
                $("#widget-grid-cliente").find("#empresa option:selected").each(function(){
                    var bancos = $(this).attr('bancos').split(',');

                    for(b in bancos){
                        banco += ' id = '+bancos[b]+' or ';
                    }

                });
                banco = banco.substr(0,banco.length-4);
                banco += ')';

                $.post('server/recupera.php',{tabela:"banco where grp_emp_id = <?php echo $empresa;?> and "+banco}).done(function(data){
                    var obj2 = JSON.parse(data);
                    for(o in obj2){
                        if(o == 0){
                            $("#widget-grid-cliente").find("#banco").empty().append('<option value="'+obj2[o].id+'">'+obj2[o].banco+'</option>');
                        }
                        else{
                            $("#widget-grid-cliente").find("#banco").append('<option value="'+obj2[o].id+'">'+obj2[o].banco+'</option>');
                        }
                    }
                    banco = '(';
                }).fail(function(){
                    banco = '(';
                });
            }else{
                $.post('server/recupera.php',{tabela:"banco  where grp_emp_id = <?php echo $empresa;?>"}).done(function(data){
                    var obj2 = JSON.parse(data);
                    for(o in obj2){
                        if(o == 0){
                            $("#widget-grid-cliente").find("#banco").empty().append('<option value="'+obj2[o].id+'">'+obj2[o].banco+'</option>');
                        }
                        else{
                            $("#widget-grid-cliente").find("#banco").append('<option value="'+obj2[o].id+'">'+obj2[o].banco+'</option>');
                        }
                    }
                    banco = '(';
                }).fail(function(){
                    banco = '(';
                });
            }

            $("#widget-grid-cliente").find('#banco').removeAttr('disabled');
        }else{
            $("#widget-grid-cliente").find('#banco').attr('disabled',true);
            $("#widget-grid-cliente").find("#banco").select2('val','');
        }
    });

    $("#widget-grid-cliente").find("#empresa").change(function(){
       if($("input[name='checkbox_banco']:checked").length == 1){
           if($("#widget-grid-cliente").find("#empresa option:selected").length >0) {
               $("#widget-grid-cliente").find("#empresa option:selected").each(function () {
                   var bancos = $(this).attr('bancos').split(',');

                   for (b in bancos) {
                       banco += ' id = ' + bancos[b] + ' or ';
                   }

               });
               banco = banco.substr(0, banco.length - 4);
               banco += ')';

               $.post('server/recupera.php', {tabela: "banco where grp_emp_id = <?php echo $empresa;?> and " + banco}).done(function (data) {
                   var obj2 = JSON.parse(data);
                   for (o in obj2) {
                       if (o == 0) {
                           $("#widget-grid-cliente").find("#banco").empty().append('<option value="' + obj2[o].id + '">' + obj2[o].banco + '</option>');
                       }
                       else {
                           $("#widget-grid-cliente").find("#banco").append('<option value="' + obj2[o].id + '">' + obj2[o].banco + '</option>');
                       }
                   }
                   banco = '(';
               }).fail(function () {
                   banco = '(';
               });
           };
       }
    });

    $("#widget-grid-cliente").find('input[name="checkbox_pessoa"]').change(function(){
        if(this.checked){
            $("#widget-grid-cliente").find('#pessoa').removeAttr('disabled');
        }else{
            $("#widget-grid-cliente").find('#pessoa').attr('disabled',true);
            $("#widget-grid-cliente").find("#pessoa").val('');
            $("#widget-grid-cliente").find("#retorno").val('');
        }
    });

    $("#widget-grid-cliente").find('input[name="checkbox_centrocusto"]').change(function(){
        if(this.checked){
            $("#widget-grid-cliente").find('#centrocusto').removeAttr('disabled');
        }else{
            $("#widget-grid-cliente").find('#centrocusto').attr('disabled',true);
            $("#widget-grid-cliente").find("#centrocusto").select2('val','');
        }
    });

    $("#widget-grid-cliente").find('input[name="checkbox_natureza"]').change(function(){
        if(this.checked){
            $("#widget-grid-cliente").find('#natureza').removeAttr('disabled');
        }else{
            $("#widget-grid-cliente").find('#natureza').attr('disabled',true);
            $("#widget-grid-cliente").find("#natureza").select2('val','');
        }
    });

    $("#widget-grid-cliente").find('input[name="checkbox_pagamento"]').change(function(){
        if(this.checked){
            $("#widget-grid-cliente").find('#pagamento').removeAttr('disabled');
        }else{
            $("#widget-grid-cliente").find('#pagamento').attr('disabled',true);
            $("#widget-grid-cliente").find("#pagamento").select2('val','');
        }
    });
    var date = new Date(), y = date.getFullYear(), m = date.getMonth();
    var firstDay = new Date(y, m, 1);
    var lastDay = new Date(y, m + 1, 0);
    // Date Range Picker
    $("#from").datepicker({
        date:firstDay,
        defaultDate: firstDay,
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
    $("#to").datepicker({
        defaultDate: lastDay,
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

    // busca empresa
    $.post("server/recupera.php",{tabela:'empresa where grp_emp_id = <?php echo $empresa;?> and tipo = 1'}).done(function(data){
        var obj = JSON.parse(data);
        for(o in obj){
            if(o == 0){
                $("#widget-grid-cliente").find("#empresa").empty().append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
            }else{
                $("#widget-grid-cliente").find("#empresa").append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
            }
        }
        $("#widget-grid-cliente").find("#empresa,#banco").select2();
    }).fail(function(){

    });



    // busca formas de pagamento
    $.post("server/recupera.php",{tabela:'pagamento where grp_emp_id = <?php echo $empresa;?>'}).done(function(data){
        var obj = JSON.parse(data);
        for(o in obj){
            if(o == 0){
                $("#widget-grid-cliente").find("#pagamento").empty().append('<option condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
            }else{
                $("#widget-grid-cliente").find("#pagamento").append('<option condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
            }
        }
        $("#widget-grid-cliente").find("#pagamento").select2();
    }).fail(function(){

    });


    var tipo;
    if($("#tipo").val() == 3 || $("#tipo").val() == 1 ){
        tipo = 1;
    }else{
        tipo = 2;
    }
    $.post("server/recupera.php",{tabela:'natureza where grp_emp_id = <?php echo $empresa;?> and tipo like "%'+tipo+'%"'}).done(function(data){
        var obj = JSON.parse(data);
        for(o in obj){
            if(o == 0){
                $("#widget-grid-cliente").find("#natureza").empty().append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
            }else{
                $("#widget-grid-cliente").find("#natureza").append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
            }
        }
        $("#widget-grid-cliente").find("#natureza").select2();
    }).fail(function(){

    });

    $("#tipo").change(function(){
        //busca natureza financeira
        if($(this).val() == 3 || $(this).val() == 1 ){
            tipo = 1;
        }else{
            tipo = 2;
        }
        $.post("server/recupera.php",{tabela:'natureza where grp_emp_id = <?php echo $empresa;?> and tipo like "%'+tipo+'%"'}).done(function(data){
            var obj = JSON.parse(data);
            for(o in obj){
                if(o == 0){
                    $("#widget-grid-cliente").find("#natureza").empty().append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
                }else{
                    $("#widget-grid-cliente").find("#natureza").append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
                }
            }
            $("#widget-grid-cliente").find("#natureza").select2();
        }).fail(function(){

        });
    });

    //busca centro de custo
    $.post("server/recupera.php",{tabela:'centrocusto where grp_emp_id = <?php echo $empresa;?>'}).done(function(data){
        var obj = JSON.parse(data);
        for(o in obj){
            if(o == 0){
                $("#widget-grid-cliente").find("#centrocusto").empty().append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
            }else{
                $("#widget-grid-cliente").find("#centrocusto").append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
            }
        }
        $("#widget-grid-cliente").find("#centrocusto").select2();
    }).fail(function(){

    });


    $.validator.setDefaults({ ignore: '' });

    $("#rel-form").validate({
        // Rules for form validation
        rules : {
            from : {
                required : true
            },
            to : {
                required : true
            }
        },

        // Messages for form validation
        messages : {
            from : {
                required : 'Por favor, informe uma data inicial!'
            },
            to : {
                required : 'Por favor, informe uma data final!'
            }
        },
        success: 'valid',

// This does the actual form submitting
        submitHandler: function (form) {
            form.submit();
        },

        // Do not change code below
        errorPlacement : function(error, element) {
            error.insertAfter(element.parent());
        }
    });



</script>