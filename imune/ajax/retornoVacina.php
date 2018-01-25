    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-green" id="wid-id-0" data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Retorno </h2>
                    <div class="widget-toolbar" role="menu">
                        <a id="novo" class="btn btn-primary" href="javascript:void(0);">Novo</a>
                    </div>
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                    </div>
                    <div class="widget-body no-padding">

                        <table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">

                            <thead>
                            <tr>
                                <th class="hasinput" style="width:10%">
                                    <input id="dateselect_filter" type="text" placeholder="Data Aplicação" class="form-control datepicker" data-dateformat="yy/mm/dd">
                                </th>
                                <th class="hasinput" style="width:10%">
                                    <input id="dateselect_filter" type="text" placeholder="Data Retorno" class="form-control datepicker" data-dateformat="yy/mm/dd">
                                </th>
                                <th class="hasinput" style="width:15%">
                                    <div>
                                        <input class="form-control" placeholder="Vacina" type="text">
                                    </div>
                                </th>
                                <th class="hasinput" style="width:10%">
                                    <input type="text" class="form-control" placeholder="Dose" />
                                </th>
                                <th class="hasinput" style="width:15%">
                                    <input type="text" class="form-control" placeholder="Lote" />
                                </th>
                                <th class="hasinput" style="width:10%">
                                    <input type="text" class="form-control" placeholder="Usuario" />
                                </th>
                                <th class="hasinput" style="width:10%">
                                    <input type="text" class="form-control" placeholder="Unidade" />
                                </th>
                            </tr>
                            <tr>
                                <th data-class="expand">Data Aplicação</th>
                                <th data-class="expand">Data Retorno</th>
                                <th data-hide="phone">Vacina</th>
                                <th data-hide="phone,tablet">Dose</th>
                                <th data-hide="phone,tablet">Lote</th>
                                <th data-hide="phone">Usuario</th>
                                <th data-hide="phone,tablet">Unidade</th>
                            </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script type="text/javascript">
    pageSetUp();


    $('#novo').click(function() {
        $.post('ajax/cadRetorno.php').done(function(data){
            $("#cadastro").empty().html(data);
            $("#cadastro").dialog({
                autoOpen : true,
                width : '90%',
                resizable : false,
                modal : true,

            });
        }).fail(function(){
            alerta("ERRO!","Função não encontrada!","danger","ban");
        });
    });



    var pagefunction = function() {
        var responsiveHelper_dt_basic = undefined;
        var responsiveHelper_datatable_fixed_column = undefined;
        var responsiveHelper_datatable_col_reorder = undefined;
        var responsiveHelper_datatable_tabletools = undefined;

        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };

        $('#dt_basic').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic.respond();
            }
        });
        var otable = $('#datatable_fixed_column').DataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_fixed_column) {
                    responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_fixed_column.respond();
            }

        });
    };
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