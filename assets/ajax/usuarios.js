var table;

$(document).ready(function() {
    if($('table#usuarios').length) {
        listar();
    }

    if($('#oldType').length) {
        $('#type').val($('#oldType').val());
    }

    if($('input[name="uniqid"]').length) {
        let uniqid = $('#uniqid').val();
        let params = {
            'uniqid': uniqid
        }

        $.post(getURL() + 'usuarios/permisos', params, null, 'JSON')
        .done(function(response) {
            table = $('#permisos').DataTable({
                scrollX: true,
                autoWidth: false,
                language: {
                    url: getURL() + 'assets/plugins/datatables/spanish.json'
                },
                data: response,
                columns: [
                    { data: 'id', className: 'text-center' },
                    { data: 'module', className: 'text-center' },
                    { 
                        data: 'can_view', 
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data == 1 ? '<span class="badge bg-success">SI</span>' : '<span class="badge bg-danger">NO</span>'
                        }
                    },
                    { 
                        data: 'can_add', 
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data == 1 ? '<span class="badge bg-success">SI</span>' : '<span class="badge bg-danger">NO</span>'
                        }
                    },
                    { 
                        data: 'can_edit', 
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data == 1 ? '<span class="badge bg-success">SI</span>' : '<span class="badge bg-danger">NO</span>'
                        }
                    },
                    { 
                        data: 'can_delete', 
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data == 1 ? '<span class="badge bg-success">SI</span>' : '<span class="badge bg-danger">NO</span>'
                        }
                    },
                    { 
                        data: 'can_auth', 
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data == 1 ? '<span class="badge bg-success">SI</span>' : '<span class="badge bg-danger">NO</span>'
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        defaultContent: '<button type="button" class="btn btn-xs bg-lightblue edit_permission"><i class="fas fa-edit"></i> Editar</button>'
                    }
                ]
            });
        });
    }

    $('#password, #confirm-password').on('keyup', function() {
        if($('#password').val() == $('#confirm-password').val() && $('#password').val().length > 0) {
            $('#password, #confirm-password').removeClass('is-invalid').addClass('is-valid');
            $('#submit').attr('disabled', false);
        } else {
            $('#password, #confirm-password').removeClass('is-valid').addClass('is-invalid');
            $('#submit').attr('disabled', true);
        }
    });

    $("#permisos").on('click', 'button.edit_permission', function(e) {
        e.preventDefault();
        let data = table.row($(this).parents('tr')).data();

        $('#p_permission_id').val(data.id);
        $('#p_module').val(data.module);
        $('#p_can_view').val(data.can_view);
        $('#p_can_add').val(data.can_add);
        $('#p_can_edit').val(data.can_edit);
        $('#p_can_delete').val(data.can_delete);
        $('#p_can_auth').val(data.can_auth);
        $('#p_user_id').val(data.user_id);

        $('#modal-permissions').modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    });

    $('#form-permissions').on('submit', function(event) {
        event.preventDefault();
        $.post(getURL() + 'usuarios/permisos/actualizar', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
           }
        }, 'JSON');
    });
   
    $('#form-user-add').on('submit', function(event) {
        event.preventDefault();
        $.post(getURL() + 'usuarios/agregar', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.replace(getURL() + 'usuarios/editar/' + response.uniqid);
            } else {
                showError(response.code);
            }
        }, 'JSON');
    });

    $('#form-user-edit').on('submit', function(event) {
            event.preventDefault();
            $.post(getURL() + 'usuarios/editar', $(this).serialize(), function(response) {
            if(response.status) {
                window.location.reload();
            } else {
                showError(response.code);
            }
        }, 'JSON');
    });
});

function listar() {
    $.post(getURL() + 'usuarios/listar', null, null, 'JSON')
    .done(function(response) {
        table = $("#usuarios").DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: getURL() + 'assets/plugins/datatables/spanish.json'
            },
            data: response,
            columns: [
                { data: 'username', className: 'text-center' },
                { data: 'fullname' },
                { data: 'email' },
                { 
                    data: 'type', 
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<span class="badge bg-primary">' + data + '</span>'
                    }
                },
                { data: 'register', className: 'text-center' },
                { data: 'lastlogin', className: 'text-center' },
                { data: 'lastactivity', className: 'text-center' },
                { 
                    data: 'state',
                    className: "text-center",
                    render: function(data, type, row) {
                        return data == 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>';
                    } 
                },
                { 
                    data: 'uniqid', 
                    className: "text-center",
                    render: function(data, type, row) {
                        return '<a href="' + getURL() + 'usuarios/editar/' + data + '" class="btn btn-xs bg-lightblue"><i class="fas fa-edit"></i> Editar</a>';
                    }
                }
            ]
        });
    });
}