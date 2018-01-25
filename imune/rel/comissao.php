<?php
    require_once "../server/seguranca.php";
    $empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>
<section id="widget-grid-cliente" class="well">
    <form action="rel/relComissao.php" method="post" target="_blank" id="rel-form" class="smart-form client-form">
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 text-align-right">

            </div>
            <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
                <h2>RELATÓRIO DE PAGAMENTO DE COMISSÃO</h2>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 text-align-right">

            </div>
            <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
                <div class="form-group">
                    <label for="form-field-select-3">TIPO</label>
                    <div>
                        <select class="form-control" id="tipo" name="tipo" style="width: 100%;">
                            <option value="1" selected>GERAL</option>
                            <option value="2">COMISSÕES PENDENTES / FUTURAS</option>
                            <option value="3">COMISSÕES BAIXADAS</option>
                            <option value="4">COMISSÕES PAGAS</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 align-right">

            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-5">
                <section>
                    <label class="input"> Data Inicial
                        <input id="from" name="from" style="width:99%;">
                        <b class="tooltip tooltip-top-right"> Por favor, informe uma data inicial!</b></label>
                </section>
        </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-5">
                <section>
                    <label class="input">Data Final
                        <input id="to"  name="to"  style="width:98%;margin-left:2%">
                        <b class="tooltip tooltip-top-right">Por favor, informe uma data final!</b> </label>
                </section>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 text-align-right">

            </div>
            <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
                <section>
                    <label class="input">PRODUTOR / CORRETOR
                        <input id="cli_id"  name="cli_id">
                        <input id="retorno" name="retorno" class="form-control" type="hidden">
                        <b class="tooltip tooltip-top-right"></b> </label>
                </section>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 text-align-right">

            </div>
            <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
                <div class="form-group">
                    <label for="form-field-select-3">SEGURADORA</label>
                    <div>
                        <select class="form-control" id="seguradora" name="seguradora[]" multiple style="width: 100%; height: auto">
                            <option value="999" selected>TODAS</option>
                        </select>
                    </div>
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


    $('input[id=cli_id]').autocomplete({
        source: "ajax/buscaPro.php",
        delay:1500,
        select: function(event,ui){
            $('input[id=retorno]').val(ui.item.id);
            $('input[id=cli_id]').attr("value",ui.item.nome);
        },
        search: function(event,ui){

        },
        response: function(event,ui){
            if(ui.content.length == 0){
                $('input[id=retorno]').val('');
                $('input[id=cli_id]').attr("value",'');
                $('input[id=cli_id]').val('');
            }
            loading("hide");
        }
    });

    $('input[id=cli_id]').keyup(function(){
        if($(this).val().length == 0){
            $('input[id=retorno]').val('');
            console.log($('input[id=retorno]').val());
        }
    });

    $.post('server/recupera.php',{tabela:"pessoa where seg = 1"}).done(function(data){
        var obj = JSON.parse(data);
        for(i in obj){
            $("#seguradora").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
        }
        $("#seguradora").select2();

    }).fail(function(){

    });


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



$("#seguradora").change(function(){
    var seg = $(this).val();
    for(s in seg){
        if(seg[s] == 999){
            $("#seguradora option:selected").each(function(){
                $(this).removeAttr('selected');
            });
            $("#seguradora").select2('val',999);
        }
    }
});

</script>