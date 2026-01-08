<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">{$settings['systemname']}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-primary">
                        <form action="" id="form-settings-edit" method="post" autocomplete="off">
                            <div class="card-header bg-primary">
                                <div class="row">
                                    <div class="text-left col-sm-12 align-self-center">
                                        <h3 class="card-title">Configuración de la plataforma.</h3>
                                    </div>
                                    <!-- <div class="text-right col-sm-2">
                                        <a href="{$settings['url']}/usuarios/agregar" class="btn btn-default text-dark">
                                            <i class="fas fa-plus"></i>
                                            Nuevo usuario
                                        </a>
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="systemname">Nombre del Sistema</label>
                                                    <input type="text" name="systemname" id="systemname" value="{$settings['systemname']}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="url">URL del Sistema</label>
                                                    <input type="url" name="url" id="url" value="{$settings['url']}" class="form-control" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="timezone">Zona Horaria</label>
                                                    <input type="text" name="timezone" id="timezone" value="{$settings['timezone']}" class="form-control" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="date_format">Formato de Fecha</label>
                                                    <input type="text" name="date_format" id="date_format" value="{$settings['date_format']}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="time_format">Formato de Hora</label>
                                                    <input type="text" name="time_format" id="time_format" value="{$settings['time_format']}" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="cookie_domain">Dominio de la Cookie</label>
                                                    <input type="text" name="cookie_domain" id="cookie_domain" value="{$settings['cookie_domain']}" class="form-control" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="cookie_path">Directorio de la Cookie</label>
                                                        <input type="text" name="cookie_path" id="cookie_path" value="{$settings['cookie_path']}" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="cookie_prefix">Prefijo de la Cookie</label>
                                                        <input type="text" name="cookie_prefix" id="cookie_prefix" value="{$settings['cookie_prefix']}" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="cookie_expire">Duración de la sesión <small>(Expresado en segundos)</small></label>
                                                        <input type="number" name="cookie_expire" id="cookie_expire" value="{$settings['cookie_expire']}" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pt-3 border-top">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="currency_symbol">Símbolo de la Moneda</label>
                                                    <input type="text" name="currency_symbol" id="currency_symbol" value="{$settings['currency_symbol']}" class="form-control" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="decimals">Número de Decimales (Importes)</label>
                                                    <input type="number" name="decimals" id="decimal" min="1" step="1" value="{$settings['decimals']}" class="form-control" required> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pt-3 border-top">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="max_day_requisitions">Máximo de Días sin atender una requisición</label>
                                                    <input type="number" name="max_day_requisitions" id="max_day_requisitions" min="1" step="1" value="{$settings['max_day_requisitions']}" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Actualizar configuración</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{$settings['url']}/assets/ajax/parametros.js?v={$v}"></script>