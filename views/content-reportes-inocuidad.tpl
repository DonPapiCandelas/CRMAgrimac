<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Reportes de inocuidad (Auditoria)</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="row">
                                <div class="text-left col-sm-10 align-self-center">
                                    <h3 class="card-title">Detalle de movimientos del producto</h3>
                                </div>
                                <div class="text-right col-sm-2">
                                    <a href="#" data-toggle="modal" data-target="#modal-report-imprimir" class="btn btn-default text-dark">
                                        <i class="fas fa-print"></i> Imprimir Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="inocuidad" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Lugar de Aplicación</th>
                                        <th>Fecha</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Recibio</th>
                                        <th>Entrego</th>
                                        <th>Saldo</th>
                                        <th>Caducidad</th>
                                        <th>Proveedor</th>
                                        <th>Formulacion</th>
                                        <th>Presentación</th>
                                        <th>Lote</th>
                                        <th>RSCO</th>
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

<div class="modal fade" id="modal-report-imprimir">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-olive">
                <h5 class="modal-title">Imprimir reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="" id="form-report-print" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="R_Realiza">Realizado por:</label>
                            <input type="text" name="R_Realiza" id="R_Realiza" class="form-control uppercase" required>
                        </div>
                        <div class="form-group col">
                            <label for="R_Revisa">Revisado por:</label>
                            <input type="text" name="R_Revisa" id="R_Revisa" class="form-control uppercase" required>
                        </div>
                        <div class="form-group col">
                            <label for="R_Responsable">Responsable de Recepción:</label>
                            <input type="text" name="R_Responsable" id="R_Responsable" class="form-control uppercase" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="R_Cultivos">Cultivos:</label>
                            <input type="text" name="R_Cultivos" id="R_Cultivos" class="form-control uppercase" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="R_Empresa">Formato Empresa:</label>
                            <select name="R_Empresa" id="R_Empresa" class="form-control">
                                <option value="Hidroponia_Abanicos">Hidroponia - Rancho Abanicos</option>
                                <option value="Hidroponia_Figueroa">Hidroponia - Rancho Figueroa</option>
                                <option value="Cultivos">Cultivos Protegidos</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label for="R_Formato">Tipo de Archivo:</label>
                            <select name="R_Formato" id="R_Formato" class="form-control">
                                <option value="xlsx">Archivo de Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <input type="hidden" name="R_FechaInicio" id="R_FechaInicio">
                    <input type="hidden" name="R_FechaFinal" id="R_FechaFinal">
                    <input type="hidden" name="R_Producto" id="R_Producto">
                    <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Imprimir reporte</button>
                </div>
            </form>            
        </div>
    </div>
</div>

<div class="modal fade" id="modal-report">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-report" method="post" autocomplete="off">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Ajustes reporte</h5>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="reportDate">Rango de Fechas:</label>
                            <input type="text" class="form-control" name="reportDate" id="reportDate" required>
                        </div>
                        <div class="form-group col">
                            <label for="product">Producto:</label>
                            <select name="product" id="product" class="form-control select2" required></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Ejecutar reporte</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .select2-container {
        width: 100% !important;
    }
</style>

<script src="{$settings['url']}/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/moment/moment-with-locales.min.js"></script>
<script src="{$settings['url']}/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/ajax/reportes/inocuidad.js?v={$v}"></script>