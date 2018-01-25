<?php
    require_once "../server/seguranca.php";
    $empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>

 <div class="jarviswidget jarviswidget-color-green" id=cadVacina">

    <header>
        <h2>RELATORIO</h2>
    </header>
    <div class="widget-body">

                <form action="rel/relExtratoBanco.php" method="post" target="_blank" id="rel-form" class="smart-form client-form">
                    <div class="row">
                        <div class="col-lg-4 col-lg-push-4 col-md-6  col-sm-8 col-xs-10" align="center">
                            <h2>RELATÓRIO - VENDAS POR UNIDADE</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-lg-push-4 col-md-6 col-sm-3">
                            Unidade<select class="form-control" id="unidade">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-lg-push-4 col-md-6 col-sm-3">
                            Vacina<select class="form-control" id="vacina">
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-lg-push-4 col-md-3 col-sm-4 col-xs-5">
                            <label class="input"> Data Inicial
                                <input id="from" name="from" style="width:97%;">
                                <b class="tooltip tooltip-top-right"> Por favor, informe uma data inicial!</b></label>
                        </div>
                        <div class="col-lg-2 col-lg-push-4 col-md-3 col-sm-4 col-xs-5">
                            <label class="input">Data Final
                                <input id="to"  name="to">
                                <b class="tooltip tooltip-top-right">Por favor, informe uma data final!</b> </label>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-2 col-lg-push-5 col-md-2 col-sm-3 col-xs-6">
                            <br> <a id="email" class="btn btn-block btn-primary" style="height: 35px; width: 99%; href="javascript:void(0);">
                            <span class="btn-label">
                            <i class="glyphicon glyphicon-file"></i></span>Gerar Relatório</a>
                        </div>
                    </div>
                </form>
    </div>
</div>

<script>

    $("#cadastro").hide();
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
                $.post('server/recupera.php',{tabela:"banco where grp_emp_id = <?php echo $empresa;?>"}).done(function(data){
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

                $.post('server/recupera.php',{tabela:"banco where grp_emp_id = <?php echo $empresa;?>' and "+banco}).done(function(data){
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
                $.post('server/recupera.php',{tabela:"banco where grp_emp_id = <?php echo $empresa;?>'"}).done(function(data){
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

               $.post('server/recupera.php', {tabela: "banco where grp_emp_id = <?php echo $empresa;?>' and " + banco}).done(function (data) {
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
    $.post("server/recupera.php",{tabela:'empresa where tipo = 1'}).done(function(data){
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
    $.post("server/recupera.php",{tabela:'pagamento'}).done(function(data){
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
    //busca centro de custo
    $.post("server/recupera.php",{tabela:'centrocusto'}).done(function(data){
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
    //busca natureza financeira
    $.post("server/recupera.php",{tabela:'natureza'}).done(function(data){
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