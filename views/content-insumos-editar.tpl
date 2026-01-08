<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Detalle de la Solicitud de Insumo #{$values->id}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="invoice px-3 mb-3">
                        <div class="row py-3 border-bottom">
                            <div class="col-sm-12">
                                <div class="float-left">
                                    <a href="{$settings['url']}/insumos" class="btn bg-primary btn-app m-0">
                                        <i class="fas fa-arrow-left"></i> Regresar
                                    </a>
                                </div>
                                <div class="float-right">
                                    <button id="authDocument" class="btn bg-success btn-app m-0" {$values->doAll}>
                                        <i class="fas fa-check"></i> Aceptar Documento
                                    </button>
                                    <button id="confirmAuthDocument" class="btn bg-primary btn-app m-0" {$values->doAuth}>
                                        <i class="fas fa-check"></i> Autorizar Salida
                                    </button>
                                    <button id="cancelDocument" class="btn bg-danger btn-app m-0" {$values->doAll}>
                                        <i class="fas fa-ban"></i> Cancelar
                                    </button>
                                    <button id="exportDocument" class="btn btn-app m-0 d-none">
                                        <i class="fas fa-file-export"></i> Exportar Comercial
                                    </button>
                                    <input type="hidden" name="state" id="state" value="{$values->state}">
                                    <input type="hidden" name="exported" id="exported" value="{$values->exported}">
                                </div>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-sm-12">
                                <h4 class="float-left m-0">
                                    <i class="fas fa-user"></i> Usuario que solicita: {$values->fullname} <br>
                                    <span class="h6">Motivo: {$values->justify}</span>
                                </h4>
                                <small class="float-right h6 text-right font-italic">
                                    Fecha de Solicitud: {$values->date}
                                </small>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-sm-8">
                                <strong>Proceso:</strong> {$values->state} <br>
                                <strong>Status:</strong> {$values->cancelled} <br>
                                <div id="cancelInfo" class="mt-3">
                                    <strong>Cancelado por:</strong> <span id="cancelledBy">{$values->cancelled_by}</span> <br>
                                    <strong>Fecha cancelación:</strong> {$values->cancelled_date} <br>
                                    <strong>Mótivo cancelación:</strong> {$values->cancelled_text}
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <strong>Identificador:</strong> <span id="DocumentID">{$values->uniqid}</span> <br>
                                <div id="authInfo" class="mt-3">
                                    <strong>Autorizado por:</strong> <span id="authBy">{$values->authorized_by}</span> <br>
                                    <strong>Fecha Autorización:</strong> {$values->authorized_date}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table class="table table-striped" id="productos-insumo"> 
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Cant.</th>
                                            <th>Producto</th>
                                            <th>U.M</th>
                                            <th>Centro Costo</th>
                                            <th>Almacen</th>
                                            <th>Observaciones</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="lead mb-0">Observaciones del Solicitante:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">{$values->observations}</p>
                            </div>
                        </div>
                        <div class="row mt-5 mb-3">
                            <div class="col-sm-12 table-responsive">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <p class="lead">Notas Administrativas:</p>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <button class="btn bg-primary" data-toggle="modal" data-target="#modal-addNote">
                                            <i class="fas fa-plus fa-fw"></i> Agregar Nota
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-striped" id="notas-insumo">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 10%;">Fecha</th>
                                            <th>Nota</th>
                                            <th style="width: 10%;">Usuario</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-cancelDocument">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-cancelDocument" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Cancelar Solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cancelText">Especificar el motivo de la cancelación:</label>
                                <textarea name="cancelText" id="cancelText" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editRow">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-editRow" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Editar Partida: <span id="r_product"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-2">
                            <label for="quantity">Cantidad</label>
                            <input type="number" name="r_quantity" id="r_quantity" class="form-control" min="1" step="0.01" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-10">
                            <label for="r_product_id_select">Producto</label>
                            <select name="r_product_id_select" id="r_product_id_select" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-5">
                            <label for="r_cost_center">Centro de Costo</label>
                            <select name="r_cost_center" id="r_cost_center" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-5">
                            <label for="r_depot_id">Almacen</label>
                            <select name="r_depot_id" id="r_depot_id" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-2">
                            <label for="r_stock">Stock</label>
                            <input type="text" name="r_stock" id="r_stock" class="form-control" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-3">
                            <label for="r_lote">Lote</label>
                            <input type="text" name="r_lote" id="r_lote" class="form-control" autocomplete="off" >
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="r_caducidad">Fecha de Caducidad</label>
                            <input type="text" name="r_caducidad" id="r_caducidad" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask autocomplete="off" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="r_observations">Observaciones de la partida:</label>
                            <textarea name="r_observations" id="r_observations" class="form-control" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <input type="hidden" name="r_uniqid" id="r_uniqid">
                    <input type="hidden" name="r_product_id" id="r_product_id">
                    <button type="submit" id="editarFila" class="btn btn-primary" disabled><i class="fas fa-save fa-fw"></i> Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-addNote">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-addNote" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Agregar Nota a la Solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="rn_observations">Nota:</label>
                            <textarea name="rn_observations" id="rn_observations" class="form-control" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <input type="hidden" name="rn_uniqid" id="rn_uniqid">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicional" tabindex="-1" role="dialog" aria-labelledby="modalAdicionalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-olive">
                <h5 class="modal-title" id="modalAdicionalLabel">Información adicional de la partida: <span id="Producto"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="plaga">Plaga:</label>
                            <input type="text" name="plaga" id="plaga" class="form-control" readonly autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="dosis_hectarea">Dosis por Hectarea:</label>
                            <input type="text" name="dosis_hectarea" id="dosis_hectarea" class="form-control" readonly autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="dosis_tambo">Dosis por Tambo:</label>
                            <input type="text" name="dosis_tambo" id="dosis_tambo" class="form-control" readonly autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="ph">PH:</label>
                            <input type="text" name="ph" id="ph" class="form-control" readonly autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="valvula">Valvula:</label>
                            <input type="text" name="valvula" id="valvula" class="form-control" readonly autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="drenaje">Drenaje:</label>
                            <input type="text" name="drenaje" id="drenaje" class="form-control" readonly autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="conductividad">Conductividad:</label>
                            <input type="text" name="conductividad" id="conductividad" class="form-control" readonly autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="{$settings['url']}/assets/plugins/moment/moment-with-locales.min.js"></script>
<script src="{$settings['url']}/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="{$settings['url']}/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="{$settings['url']}/assets/ajax/insumos-editar.js?v={$v}"></script> 