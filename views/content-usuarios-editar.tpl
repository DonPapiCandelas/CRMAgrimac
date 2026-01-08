<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Editar la información y los permisos del usuario</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <form action="" id="form-user-edit" method="post" autocomplete="off">
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="row">
                                    <div class="text-left col-sm-10 align-self-center">
                                        <h3 class="card-title">Editando la información del usuario: {$values->fullname}</h3>
                                    </div>
                                    <div class="text-right col-sm-2">
                                        <a href="{$settings['url']}/usuarios" class="btn btn-default text-dark">
                                            <i class="fas fa-arrow-left"></i>
                                            Regresar al Listado
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="username">Clave de Usuario</label>
                                                    <input type="text" name="username" id="username" class="form-control" value="{$values->username}" autocomplete="off" required disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label for="fullname">Nombre Completo del Usuario</label>
                                                    <input type="text" name="fullname" id="fullname" class="form-control" value="{$values->fullname}" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="password">Cambiar contraseña de acceso</label>
                                                    <input type="password" name="password" id="password" class="form-control" value="" minlength="8" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="confirm-password">Confirmar la contraseña de acceso</label>
                                                    <input type="password" name="confirm-password" id="confirm-password" class="form-control" value="" minlength="8" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="email">Correo Electrónico del Usuario</label>
                                                    <input type="email" name="email" id="email" class="form-control" value="{$values->email}" autocomplete="off" required >
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="type">¿Tipo de Usuario?</label>
                                                    <select name="type" id="type" class="form-control" required>
                                                        <option value="1">Administrador</option>
                                                        <option value="2">Requisitador</option>  
                                                        <option value="3">Manejo de Ordenes de Compra</option>  
                                                        <option value="4">Autorizador de Ordenes</option>                                                       
                                                    </select>
                                                    <input type="hidden" name="oldType" id="oldType" value="{$values->type}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6 align-self-center">
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input" name="state" id="state" {$values->state}>
                                                    <label for="state" class="custom-control-label">Estado del Usuario. (Verde = Activo | Rojo = Inactivo)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3"><strong>Fecha de Registro:</strong><br />{$values->register}</div>
                                            <div class="col-sm-3"><strong>Último Inicio de Sesión:</strong><br /> {$values->lastlogin}</div>
                                            <div class="col-sm-3"><strong>Última Actividad:</strong><br /> {$values->lastactivity}</div>
                                            <div class="col-sm-3"><strong>Clave de Inicio de Sesión:</strong><br /> {$values->loginkey}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <input type="hidden" name="uniqid" id="uniqid" value="{$values->uniqid}" />
                                <button type="submit" id="submit" class="btn btn-success btn-flat">
                                    <i class="fas fa-save"></i>
                                    Actualizar Datos
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-olive">
                            <div class="row">
                                <div class="text-left col-sm-12 align-self-center">
                                    <h3 class="card-title">Editando los permisos del usuario: {$values->fullname}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="permisos" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Módulo</th>
                                        <th>¿Puede ver?</th>
                                        <th>¿Puede registrar?</th>
                                        <th>¿Puede editar?</th>
                                        <th>¿Puede eliminar?</th>
                                        <th>¿Puede autorizar?</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-permissions">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-permissions" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Editando los permisos del usuario {$values->fullname}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="p_module">Módulo:</label>
                                <input type="text" name="p_module" id="p_module" class="form-control" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="p_fullname">Nombre Completo del Usuario:</label>
                                <input type="text" name="p_fullname" id="p_fullname" class="form-control" value="{$values->fullname}" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="p_can_view">¿Puede ver?</label>
                                <select name="p_can_view" id="p_can_view" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Si</option>                                                        
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="p_can_add">¿Puede agregar?</label>
                                <select name="p_can_add" id="p_can_add" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Si</option>                                                        
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="p_can_edit">¿Puede editar?</label>
                                <select name="p_can_edit" id="p_can_edit" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Si</option>                                                        
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="p_can_delete">¿Puede eliminar?</label>
                                <select name="p_can_delete" id="p_can_delete" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Si</option>                                                        
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="p_can_auth">¿Puede autorizar?</label>
                                <select name="p_can_auth" id="p_can_auth" class="form-control" required>
                                    <option value="0">No</option>
                                    <option value="1">Si</option>                                                        
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <input type="hidden" name="p_permission_id" id="p_permission_id">
                    <input type="hidden" name="p_user_id" id="p_user_id">
                    <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/ajax/usuarios.js?v={$v}"></script>