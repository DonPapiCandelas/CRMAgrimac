<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Registrar nuevo usuario en el sistema</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <form action="" id="form-user-add" method="post" autocomplete="off">
                        <div class="card card-primary">
                            <div class="card-header">
                                <div class="row">
                                    <div class="text-left col-sm-10 align-self-center">
                                        <h3 class="card-title">Ingresa la información laboral del usuario</h3>
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
                                                    <input type="text" name="username" id="username" class="form-control" value="" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <label for="fullname">Nombre Completo del Usuario</label>
                                                    <input type="text" name="fullname" id="fullname" class="form-control" value="" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="password">Contraseña de acceso</label>
                                                    <input type="password" name="password" id="password" class="form-control" value="" minlength="8" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="confirm-password">Confirmar la contraseña de acceso</label>
                                                    <input type="password" name="confirm-password" id="confirm-password" class="form-control" value="" minlength="8" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="email">Correo Electrónico del Usuario</label>
                                                    <input type="email" name="email" id="email" class="form-control" value="" autocomplete="off" required>
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
                                                </div>
                                            </div>
                                            <div class="col-sm-6 align-self-center">
                                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                    <input type="checkbox" class="custom-control-input" name="state" id="state" required checked>
                                                    <label for="state" class="custom-control-label">Estado del Usuario. (Verde = Activo | Rojo = Inactivo)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" id="submit" class="btn btn-success btn-flat" disabled>
                                    <i class="fas fa-save"></i>
                                    Guardar Usuario
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
                                <div class="text-left col-sm-10 align-self-center">
                                    <h3 class="card-title">Asignación de los permisos del usuario.</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{$settings['url']}/assets/ajax/usuarios.js?v={$v}"></script>