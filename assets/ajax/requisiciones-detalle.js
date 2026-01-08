var TableProducts, TableNotes;
let DocumentID = document.getElementById('DocumentID').innerHTML;

$(document).ready(function() {
    if($('#cancelledBy').length) {
        if(document.getElementById('cancelledBy').innerHTML == 0) {
            $('#cancelInfo').remove();
        } else {
            DocumentStatus = false
        }
    }

    $.post(getURL() + 'requisiciones/productos/' + DocumentID, null, null, 'JSON')
    .done(function(response) {
        TableProducts = $('#productos-requisicion').DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false, 
            scrollX: true, 
            autoWidth: false, 
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            }, 
            data: response,
            columns: [
                { data: 'quantity', className: 'text-center' }, 
                { data: 'product', className: 'text-truncate' },
                { data: 'unit', className: 'text-center' },
                { data: 'cost_center', className: 'text-center' },
                { data: 'observations', className: 'text-truncate' }
            ]
        });
    });

    $.post(getURL() + 'requisiciones/notas/' + DocumentID, null, null, 'JSON')
    .done(function(notes) {
        TableNotes = $('#notas-requisicion').DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false, 
            scrollX: true, 
            autoWidth: false, 
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            }, 
            data: notes,
            columns: [
                { data: 'date', className: 'text-center text-truncate'},
                { data: 'note', className: 'text-center text-truncate' },
                { data: 'fullname', className: 'text-center' }
            ],
            order: [
                [
                    0, 'desc'
                ]
            ]
        })
    });

    $('#form-addNote').on('submit', function(e) {
        e.preventDefault();
        $('#rn_uniqid').val(DocumentID);
        $.post(getURL() + 'requisiciones/agregar/nota', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON');
    });
});