<?php
    require_once "../server/seguranca.php";
?>
<div class="page-content">
    <div class="page-header">
        <h1 class="header blue lighter"><i class="ace-icon fa fa-phone"></i> RELATÓRIO CALLCENTER</h1>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 align-right">

        </div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <div class="form-group">
                <label for="form-field-select-3">Período</label>
                <div>
                    <input type="text" class="form-control" name="datarange" id="datarange" />
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 align-right">
            <br><br><label>
                <input type="checkbox"  value="2" id="chk_den" class="ace" />
                <span class="lbl"></span>
            </label>
        </div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <div class="form-group">
                <label for="form-field-select-3">DENTISTA</label>

                <div>
                    <select class="form-control" id="dental" data-placeholder="Selecione um Dentista" disabled>
                        <option value="999">TODOS DENTISTAS</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 align-right">
            <br><br><label>
                <input type="checkbox"  value="2" id="chk_cli" class="ace" />
                <span class="lbl"></span>
            </label>
        </div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <div class="form-group">
                <label for="form-field-select-3">CLIENTE</label>

                <div>
                    <input id="cli_id" class="form-control" retorno="0" disabled>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 align-right">
            <br><br><label>
                <input type="checkbox"  value="2" id="chk_rs" class="ace" />
                <span class="lbl"></span>
            </label>
        </div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <div class="form-group">
                <label for="form-field-select-3">RESULTADO</label>

                <div>
                    <select class="form-control" id="rs" data-placeholder="RESULTADO"  disabled>
                        <option value="999">TODOS</option>
                        <option value="1">CONTATO REALIZADO COM SUCESSO</option>
                        <option value="2">RETORNAR LIGAÇÃO MAIS TARDE</option>
                        <option value="3">CAIXA POSTAL</option>
                        <option value="4">TELEFONE OCULPADO</option>
                        <option value="5">FORA DE AREA OU DESLIGADO</option>
                        <option value="6">NÚMERO DE TELEFONE NÃO EXISTE</option>
                        <option value="7">ENGANO / NÚMERO ERRADO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 align-right">
            <br><br><label>
                <input type="checkbox"  value="2" id="chk_st" class="ace" />
                <span class="lbl"></span>
            </label>
        </div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <div class="form-group">
                <label for="form-field-select-3">STATUS</label>

                <div>
                    <select class="form-control" id="st" data-placeholder="Defina o Status"  disabled>
                        <option value="999">TODOS</option>
                        <option value="1">AGENDADAS</option>
                        <option value="2">CONFIRMADAS</option>
                        <option value="3">COMPARECIDAS</option>
                        <option value="4">REMARCADAS</option>
                        <option value="5">FALTANTES</option>
                        <option value="6">ATRASADAS</option>
                        <option value="7">ENCAIXADAS</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1 align-right">
        </div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <label for="form-field-select-3">TIPO:</label>
            <div class="row">
                <div class="col-sm-4 col-xs-6">
                    <label>
                        <input value="" checked name="especial" id="especial" type="radio" class="ace" />
                        <span class="lbl"> Geral </span>
                    </label>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <label>
                        <input value="consulta.dt_start asc ,consulta.dt_start" name="especial" id="especial" type="radio" class="ace" />
                        <span class="lbl"> Data </span>
                    </label>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <label>
                        <input value="usuarios.nome asc ,consulta.dt_start" name="especial" id="especial" type="radio" class="ace" />
                        <span class="lbl"> Dentista</span>
                    </label>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <label>
                        <input value="cliente.nome asc ,consulta.dt_start" name="especial" id="especial" type="radio" class="ace" />
                        <span class="lbl"> Cliente</span>
                    </label>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <label>
                        <input value="cliente.motivo asc ,consulta.dt_start" name="especial" id="especial" type="radio" class="ace" />
                        <span class="lbl"> Resultado</span>
                    </label>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <label>
                        <input value="consulta.status asc ,consulta.dt_start" name="especial" id="especial" type="radio" class="ace" />
                        <span class="lbl"> Status</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <button id="gerar" class="btn btn-primary dark btn-block">Gerar Relatório</button>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
</div>
<script>

    $("#chk_st").change(function(){
        if(this.checked){
            $("#st").removeAttr('disabled');
        }else{
            $("#st").attr('disabled',true);
            $("#st").val('999');
        }
    });

    $("#chk_rs").change(function(){
        if(this.checked){
            $("#rs").removeAttr('disabled');
        }else{
            $("#rs").attr('disabled',true);
            $("#rs").val('999');
        }
    });

    $("#chk_cli").change(function(){
        if(this.checked){
            $("#cli_id").removeAttr('disabled');
        }else{
            $("#cli_id").attr('disabled',true);
            $("#cli_id").attr("retorno","0");
            $("#cli_id").val('');
        }
    });

    $("#chk_den").change(function(){
        if(this.checked){
            $("#dental").removeAttr('disabled');
        }else{
            $("#dental").attr('disabled',true);
            $("#dental").val('999');
        }
    });

    $('input[id=cli_id]').autocomplete({
        source: "buscaCli.php",
        select: function(event,ui){
            $('input[id=cli_id]').attr("retorno",ui.item.id);
            $('input[id=cli_id]').attr("value",ui.item.nome);
        },
        search: function(){
        },
        response: function(){
            loading("hide");
        }
    });

    moment.lang('pt-BR', {
        months : "Janeiro_Fevereiro_Março_Abril_Maio_Junho_Julho_Agosto_Setembro_Outubro_Novembro_Dezembro".split("_"),
        monthsShort : "Jan_Fev_Mar_Abr_Mai_Jun_Jul_Ago_Set_Out_Nov_Dez".split("_"),
        weekdays : "Domingo_Segunda_Terça_Quarta_Quinta_Sexta_Sábado".split("_"),
        weekdaysShort : "Dom_Seg_Ter_Qua_Qui_Sex_Sáb".split("_"),
        weekdaysMin : "Do_Se_Te_Qa_Qi_Se_Sá".split("_"),
        ordinal : function (number) {
            return number + (number === 1 ? 'er' : 'ème');
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });

    $("#datarange").daterangepicker({
        locale : {
            applyLabel: 'Aplicar',
            cancelLabel:'Sair',
            clearLabel: 'Cancelar',
            fromLabel: 'De',
            toLabel: 'Até',
            weekLabel: 'S',
            customRangeLabel: 'Personalizar Período',
            daysOfWeek: moment()._lang._weekdaysMin,
            monthNames: moment()._lang._monthsShort,
            firstDay: 0,
            format: 'YYYY-MM-DD',
            displayFormat:'YYYY-MM-DD'
        },
        displayFormat:'YYYY-MM-DD',
        startDate: new Date(new Date().setDate("01")),
        endDate: new Date()
    });
    if((new Date().getMonth()+1).toString().length == 1){
        var mes = "0"+(new Date().getMonth()+1);
    }else{
        var mes = (new Date().getMonth()+1);
    }
    if((new Date().getMonth()+1).toString().length == 1){
        var mes2 = "0"+(new Date().getMonth()+2);
    }else{
        var mes2 = (new Date().getMonth() + 2);
    }

    if(new Date().getDate().toString().length == 1){
        var dia = "0"+new Date().getDate();
    }else{
        var dia = new Date().getDate();
    }


    $("#datarange").val("01/" + mes + "/" + new Date().getFullYear() + " - "+dia+"/" + mes + "/" + (new Date().getFullYear()) );

    $.post("server/recupera.php",{tabela:'usuarios where (especial = 2 or especial = 3)'}).done(function(data){
        var obj = JSON.parse(data);
        for(c in obj){
            $("#dental").append('<option value="'+obj[c].id+'">' +
                obj[c].nome +
                '</option>');
        };

    });

    $("#gerar").click(function(){
        var dentista    = $("#dental option:selected").val();
        var status      = $("#st option:selected").val();
        var cliente     = $("#cli_id").attr("retorno");
        var resultado   = $("#rs option:selected").val();
        var data  = $("#datarange").val().split(" - ");
        var dt_ini= data[0].substr(6,4)+"-"+data[0].substr(3,2)+"-"+data[0].substr(0,2)+" 00:00:00";
        var dt_fim= data[1].substr(6,4)+"-"+data[1].substr(3,2)+"-"+data[1].substr(0,2)+" 23:59:59";
        var order = $("#especial:checked").val();
        if(data == "" || data == null){

        }else{
            window.open("rel/relCallCenter.php?dt_ini="+dt_ini+"&dt_fim="+dt_fim+"&data="+data+"&den="+dentista+"&status="+status+"&cliente="+cliente+"&resultado="+resultado+"&order="+order+"&tipo=1","_blank");
        }
    });
</script>