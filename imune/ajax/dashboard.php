<?php
require_once "../server/seguranca.php";
?>
<section id="widget-grid" class="">
    <!--<div class="row">
        <article class="col-sm-12">
            <div class="jarviswidget jarviswidget-color-darken  jarviswidget-sortable" data-widget-sortable="true" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
                <header>
                    <h2 class="font-md"><strong>ATALHOS</strong></h2>
                </header>
                <div>
                    <div class="widget-body text-center">
                        <button rel="tooltip" id="dash_btn_1"  data-placement="bottom" type="button" title="NOVO CLIENTE" class="btn  btn-metro btn-primary" style="margin:10px;">
                              <i class="fa fa-user fa-3x" style="min-width: 50px"></i>
                            <span class="font-lg hidden-mobile hidden-xs">
                                NOVO <?php echo mb_strtoupper($_SESSION['config']['cliente']);?>
                            </span>
                        </button>
                        <button rel="tooltip" id="dash_btn_2" data-placement="bottom" type="button" title="NOVA APÓLICE" class="btn  btn-metro btn-success" style="margin:10px;">
                            <i class="fa fa-car fa-3x" style="min-width: 50px"></i>
                            <span class="font-lg hidden-mobile hidden-xs">
                                NOVA APÓLICE
                            </span>
                        </button>
                        <button rel="tooltip" id="dash_btn_3" data-placement="bottom" type="button" title="ADIANTAMENTO E PREMIAÇÕES" class="btn  btn-metro btn-danger" style="margin:10px;">
                            <i class="fa fa-dollar fa-3x" style="min-width: 50px"></i>
                            <span class="font-lg hidden-mobile hidden-xs">
                                ADIAN. & PREM.
                            </span>
                        </button>
                        <button rel="tooltip" id="dash_btn_4" data-placement="bottom" type="button" title="LANÇAMENTOS CHEQUES / BOLETOS" class="btn  btn-metro btn-warning" style="margin:10px;">
                            <i style="min-width:50px; min-height: 60px"><img src="img/18-512.png" width="50px" height="50px" style="margin-top:-5px; margin-bottom:-5px;"> </i>
                            <span class="font-lg hidden-mobile hidden-xs">
                                LANÇAME. C / B
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </article>
        <article class="col-sm-12">
            <div class="jarviswidget jarviswidget-color-darken  jarviswidget-sortable" data-widget-sortable="true" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" >
                <header>
                    <h2 class="font-md"><strong>FINANCEIRO</strong></h2>
                </header>
                <div>
                    <div class="widget-body" id="topo" style="margin-bottom: 50px;">
                    <div>
                        <div class="jarviswidget-editbox">

                        </div>
                        <div class="widget-body no-padding">

                            <div id="normal-bar-graph" class="chart no-padding"></div>

                        </div>
                    </div>
                </div>
            </div>
        </article>
        <article class="col-sm-12">
            <div class="jarviswidget jarviswidget-color-darken" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false">
                <header>
                    <h2 class="font-md"><strong>PROPOSTAS / APÓLICES</strong></h2>
                </header>
                <div>
                    <div class="widget-body" id="filas">

                    </div>
                </div>
            </div>
        </article>
        <article class="col-sm-12">
            <div class="jarviswidget jarviswidget-color-darken  "  data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" >
                <header>
                    <h2 class="font-md"><strong>CLIENTES</strong></h2>
                </header>
                <div>
                    <div class="widget-body" id="centro">

                    </div>
                </div>
            </div>
        </article>
    </div>-->
</section>
<script type="text/javascript">
    limpa("#cadastro");
    pageSetUp();

    $('#dash_btn_1').click(function() {
        loading('show');
        $.post('ajax/cadcliente.php').done(function(data){
            $("#cadastro").empty().html(data);
            $("#cadastro").dialog({
                autoOpen : true,
                width : '95%',
                resizable : false,
                modal : true,
                title : "Novo <?php echo $_SESSION['config']['cliente'];?>"
            });
            loading('hide');
        }).fail(function(){
            alerta("ERRO!","Função não encontrada!","danger","ban");
            loading('hide');
        });
    });

    $("#dash_btn_2").click(function(){
        $.post("ajax/cadApolice.php").done(function(data){
            $("#cadastro").empty().html(data);
            $("#cadastro").dialog({
                autoOpen : true,
                width : '95%',
                resizable : false,
                modal : true,
                title : "Nova Apólice"
            })
            //definindo campo de autocompletar
            $("#novoApolice").find('#cli_id').autocomplete({
                source: "ajax/buscaCli.php",
                select: function(event,ui){
                    $(this).attr("retorno",ui.item.id);
                    $(this).attr("value",ui.item.nome);
                    $(this).attr("cpf",ui.item.cpf);
                },
                search:function(){
                    loading('show');
                },
                response:function(){
                    loading('hide')
                },
                delay:1000,
                minLength:3
            });
        }).fail(function(){
            alerta("ERRO!","Função não encontrada!","danger","ban");
        });
    });

    $("#dash_btn_3").click(function(){
        $.post("ajax/cadComissao.php").done(function(data){
            $("#cadastro").empty().html(data);
            $("#cadastro").dialog({
                autoOpen : true,
                width : '95%',
                resizable : false,
                modal : true,
                title : "Lançamento de Adiantamentos e Premiações"
            });
        }).fail(function(){
            alerta("ERRO!","Função não encontrada!","danger","ban");
        });
    });

    $("#dash_btn_4").click(function(){
        $.post("ajax/cadCheque.php").done(function(data){
            $("#cadastro").empty().html(data);
            $("#cadastro").dialog({
                autoOpen : true,
                width : '95%',
                resizable : false,
                modal : true,
                title : "Lanç. Cheques/Boletos"
            });

        }).fail(function(){
            alerta("ERRO!","Função não encontrada!","danger","ban");
        });
    });

    var pagefunction = function() {

        // Dialog click



        $("[rel=tooltip]").tooltip();


        if ($('#normal-bar-graph').length){

            Morris.Bar({
                element: 'normal-bar-graph',
                data: [
                    {x: 'JANEIRO', y: 3, z: 2, a: "3", b: 10},
                    {x: 'FEVEREIRO', y: 2, z: 0, a: "19", b: 10},
                    {x: 'MARÇO', y: 0, z: 2, a: 4, b: 10},
                    {x: 'ABRIL', y: 2, z: 4, a: 3, b: 10},
                    {x: 'MAIO', y: 2, z: 4, a: 3, b: 10},
                    {x: 'JUNHO', y: 2, z: 4, a: 3, b: 10},
                    {x: 'JULHO', y: 2, z: 4, a: 3, b: 10},
                    {x: 'AGOSTO', y: 2, z: 4, a: 3, b: 10},
                    {x: 'SETEMBRO', y: 2, z: 4, a: 3, b: 10},
                    {x: 'OUTUBRO', y: 2, z: 4, a: 3, b: 10},
                    {x: 'NOVEMBRO', y: 2, z: 4, a: 3, b: 10},
                    {x: 'DEZEMBRO', y: 2, z: 4, a: 3, b: 10}
                ],
                xkey: 'x',
                ykeys: ['y', 'z', 'a', 'b'],
                labels: ['À PAGAR', 'ATRASADAS', 'À RECEBER', 'RECEBIDAS'],
                barColors: ["#B29215","#B21516", "#1531B2", "#1AB244"],
                hoverCallback: function(index, options, content) {
                    var data = options.data[index];
                    $(".morris-hover").html('<div>' +
                        data.x + '' +
                        "<div style='color:"+options.barColors[0]+"'>"+options.labels[0] + ": R$ " + parseFloat(data.y).toFixed(2).replace(".",",") +"</div>"+
                        "<div style='color:"+options.barColors[1]+"'>"+options.labels[1] + ": R$ " + parseFloat(data.z).toFixed(2).replace(".",",") +"</div>"+
                        "<div style='color:"+options.barColors[2]+"'>"+options.labels[2] + ": R$ " + parseFloat(data.a).toFixed(2).replace(".",",") +"</div>"+
                        "<div style='color:"+options.barColors[3]+"'>"+options.labels[3] + ": R$ " + parseFloat(data.b).toFixed(2).replace(".",",") +"</div>"+
                        '</div>');
                }
            });

        }
        $('[text-anchor="end"]').find('tspan').each(function(){
            $(this).text(parseFloat($(this).text().replace(",","")).toFixed(2).replace(".",","));
        });


    };

    loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
        loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
            loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
                loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
                    loadScript("js/plugin/morris/raphael.min.js", function(){
                        loadScript("js/plugin/morris/morris.min.js",function(){
                            loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction);
                        });
                    });
                });
            });
        });
    });





</script>