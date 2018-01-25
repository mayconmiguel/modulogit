    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-green" id="wid-id-0" data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Medicos </h2>
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
                                <th class="hasinput" style="width:15%">
                                    <div>
                                        <input class="form-control" placeholder="id" type="text">
                                    </div>
                                </th>
                                <th class="hasinput" style="width:15%">
                                    <div>
                                        <input class="form-control" placeholder="Medico" type="text">
                                    </div>
                                </th>
                                <th class="hasinput" style="width:10%">
                                    <input type="text" class="form-control" placeholder="Telefone" />
                                </th>
                                <th class="hasinput" style="width:15%">
                                    <input type="text" class="form-control" placeholder="unidade" />
                                </th>
                                <th class="hasinput" style="width:10%">
                                    <input type="text" class="form-control" placeholder="Email" />
                                </th>
                            </tr>
                            <tr>
                                <th data-hide="phone">id</th>
                                <th data-hide="phone">Medico</th>
                                <th data-hide="phone,tablet">unidade</th>
                                <th data-hide="phone,tablet">Telefone</th>
                                <th data-hide="phone">Email</th>
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
    var pagefunction = function() {

        $('#novo').click(function() {
            $.post('ajax/cadMedico.php').done(function(data){
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
        $.fn.dataTable.ext.errMode = 'none';


        jQuery.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
        {
            // DataTables 1.10 compatibility - if 1.10 then `versionCheck` exists.
            // 1.10's API has ajax reloading built in, so we use those abilities
            // directly.
            if ( jQuery.fn.dataTable.versionCheck ) {
                var api = new jQuery.fn.dataTable.Api( oSettings );

                if ( sNewSource ) {
                    api.ajax.url( sNewSource ).load( fnCallback, !bStandingRedraw );
                }
                else {
                    api.ajax.reload( fnCallback, !bStandingRedraw );
                }
                return;
            }

            if ( sNewSource !== undefined && sNewSource !== null ) {
                oSettings.sAjaxSource = sNewSource;
            }

            // Server-side processing should just call fnDraw
            if ( oSettings.oFeatures.bServerSide ) {
                this.fnDraw();
                return;
            }

            this.oApi._fnProcessingDisplay( oSettings, true );
            var that = this;
            var iStart = oSettings._iDisplayStart;
            var aData = [];

            this.oApi._fnServerParams( oSettings, aData );

            oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
                /* Clear the old information from the table */
                that.oApi._fnClearTable( oSettings );

                /* Got the data - add it to the table */
                var aData =  (oSettings.sAjaxDataProp !== "") ?
                    that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;

                for ( var i=0 ; i<aData.length ; i++ )
                {
                    that.oApi._fnAddData( oSettings, aData[i] );
                }

                oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

                that.fnDraw();

                if ( bStandingRedraw === true )
                {
                    oSettings._iDisplayStart = iStart;
                    that.oApi._fnCalculateEnd( oSettings );
                    that.fnDraw( false );
                }

                that.oApi._fnProcessingDisplay( oSettings, false );

                /* Callback user function - for event handlers etc */
                if ( typeof fnCallback == 'function' && fnCallback !== null )
                {
                    fnCallback( oSettings );
                }
            }, oSettings );
        };

        jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "date-uk-pre": function ( a ) {
                var ukDatea = a.split('/');
                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            },

            "date-uk-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-uk-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        } );

        /* BASIC ;*/

        var responsiveHelper_datatable_col_reorder = undefined;


        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };

        $.fn.dataTable.ext.errMode = 'none'
        var medico = [
            { "data": "id"},
            { "data": "nome"},
            { "data": "unidade"},
            { "data": "telefone"},
            { "data": "email"}
        ];

        var table = $('#datatable_fixed_column').dataTable({
            "sDom": "<'dt-toolbar'<'col-sm-3 localiza col-xs-6'><'col-sm-3 dtini col-xs-12 hidden-xs'><'col-sm-3 dtfim col-xs-12 hidden-xs'><'col-sm-3 col-xs-6 hidden-xs'C>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "aLengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "TODOS"]
            ],
            "order":[[ 0, 'asc' ],[1,'desc']],
            "ajax": "server/buscaMedico.php",
            "columns": medico,
            oSearch: {"bRegex": true},
            "iDisplayLength": 10,
            "autoWidth" : true,
            "preDrawCallback" : function() {

                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_col_reorder) {
                    responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
                }
            },
            "oLanguage": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "Mostrar _MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Localizar: ",
                "oPaginate": {
                    "sPrevious": "Anterior",
                    "sNext": "Próximo",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                }
            },
            "colVis": {
                "buttonText": "Mostrar / Ocultar Colunas"
            },
            "rowCallback" : function(nRow,aData) {
                responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
                var row = table.fnGetNodes(nRow);



                // definindo cursor do mouse pra pointer;
                $(row).attr('style', 'cursor:pointer');

                $(row).dblclick(function(){
                    loading("show");
                    $.post("ajax/cadMedico.php",{id:aData.id}).done(function(data){
                        $("#cadastro").empty().html(data);
                        $("#cadastro").dialog({
                            autoOpen : true,
                            width : '95%',
                            resizable : false,
                            modal : true,
                            title : "Editar"
                        });
                    }).fail(function(){
                        alerta("ERRO!","Função não encontrada!","danger","ban");
                    });
                });

            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_col_reorder.respond();
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