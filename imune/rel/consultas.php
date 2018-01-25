<?php
    require_once "../server/seguranca.php";
?>
<div class="page-content">
    <div class="page-header">
        <h1 class="header blue lighter"><i class="ace-icon fa fa-calendar"></i> RELATÓRIO DE CONSULTAS</h1>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <div class="form-group">
                <label for="form-field-select-3">Seleção de Dentistas</label>

                <div>
                    <select class="form-control" id="dental" data-placeholder="Selecione um Dentista">
                        <option value="999">TODOS DENTISTAS</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <div class="form-group">
                <label for="form-field-select-3">Seleção de Dentistas</label>

                <div>
                    Período<input type="text" class="form-control" name="datarange" id="datarange" />
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
        <div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
            <div class="form-group">
                <label for="form-field-select-3">STATUS</label>

                <div>
                    <select class="form-control" id="st" data-placeholder="Defina o Status">
                        <option value="999">Todos Status</option>
                        <option style="background-color: #F5F5F5" value="1" color="#F5F5F5">Agendada</option>
                        <option style="background-color: #87CEFF" value="2">Confirmada</option>
                        <option style="background-color: #77ba91" value="3">Compareceu</option>
                        <option style="background-color: #FFFF00" value="4">Remarcada</option>
                        <option style="background-color: #FF8C69" value="5">Faltantes</option>
                        <option value="6" style="background-color: #5F9EA0">Atrasado</option>
                        <option value="7" style="background-color: #00FFFF">Encaixado</option>
                    </select>
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
        for(var c = 0; c<data.length;c++){
            $("#dental").append('<option value="'+obj[c].id+'">' +
                obj[c].nome +
                '</option>');
        };

    });

    $("#gerar").click(function(){
        var dentista = $("#dental option:selected").val();
        var status   = $("#st option:selected").val();
        var data  = $("#datarange").val().split(" - ");
        var dt_ini= data[0].substr(6,4)+"-"+data[0].substr(3,2)+"-"+data[0].substr(0,2)+" 00:00:00";
        var dt_fim= data[1].substr(6,4)+"-"+data[1].substr(3,2)+"-"+data[1].substr(0,2)+" 23:59:59";

        if(data == "" || data == null){

        }else{
            window.open("rel/relConsultas.php?dt_ini="+dt_ini+"&dt_fim="+dt_fim+"&data="+data+"&den="+dentista+"&status="+status+"&tipo=1","_blank");
        }
    });
</script>