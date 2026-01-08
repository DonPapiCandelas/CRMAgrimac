var table;

$(document).ready(function() {
    if($('table#existencias').length) {
        listar();
    }

    $('#existencias tbody').on( 'click', 'tr.group', function () {
        var groupColumn = 2;
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === groupColumn && currentOrder[1] === 'asc' ) {
            table.order( [ groupColumn, 'desc' ] ).draw();
        }
        else {
            table.order( [ groupColumn, 'asc' ] ).draw();
        }
    } );
});

function listar() {
    $.post(getURL() + 'reportes/existencias/listar', null, null, 'JSON')
    .done(function(response) {
        var groupColumn = 2;
        table = $("#existencias").DataTable({
            columnDefs: [
                { visible: false, targets: groupColumn }
            ],
            scrollX: true,
            autoWidth: false,
            displayLength: 50,
            order: [[ groupColumn, 'asc' ]],
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'ProductKey' },
                { data: 'ProductName' },
                { data: 'DepotName' },
                { data: 'QtyPresent', className: 'text-center' },
                { data: 'Unit', className: 'text-center' },
                //{ data: 'QtyMinimum', className: 'text-center' },
                //{ data: 'QtyMax', className: 'text-center' }
            ],
            drawCallback: function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
     
                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group bg-green"><td colspan="6">'+group+'</td></tr>'
                        );
     
                        last = group;
                    }
                } );
            }
        });
    });
}