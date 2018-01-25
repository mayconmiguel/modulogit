<script>

    var table = $('#datatable_col_reorder').dataTable({
        "sDom": "<'dt-toolbar'<'col-sm-3 localiza col-xs-6'><'col-sm-3 dtini col-xs-12 hidden-xs'><'col-sm-3 dtfim col-xs-12 hidden-xs'><'col-sm-3 col-xs-6 hidden-xs'C>r>"+
        "t"+
        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
        "aLengthMenu": [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "TODOS"]
        ],
        "order":[[ 3, 'asc' ],[0,'desc']],
        "ajax": "server/buscaCliente.php",
        "columns": cliente,
        oSearch: {"bRegex": true},
        "iDisplayLength": 10,
        "autoWidth" : true,
        "preDrawCallback" : function() {
            // Initialize the responsive datatables helper once.
            if (!responsiveHelper_datatable_col_reorder) {
                responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
            }
        },"oLanguage": {
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
            

        },
        "drawCallback" : function(oSettings) {
            responsiveHelper_datatable_col_reorder.respond();
        }
    });
    
    
</script>