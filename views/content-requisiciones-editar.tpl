<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Detalle de la Requisicion #{$values->id}</h1>
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
                                    <a href="{$settings['url']}/requisiciones" class="btn bg-primary btn-app m-0">
                                        <i class="fas fa-arrow-left"></i> Regresar
                                    </a>
                                </div>
                                <div class="float-right">
                                    <button id="authDocument" class="btn bg-success btn-app m-0" {$values->doAll}>
                                        <i class="fas fa-check"></i> Solicitar Autorización
                                    </button>
                                    <button id="confirmAuthDocument" class="btn bg-primary btn-app m-0" {$values->doAuth}>
                                        <i class="fas fa-check"></i> Autorizar Requisición
                                    </button>
                                    <button id="cancelAuth" class="btn bg-danger btn-app m-0 d-none">
                                        <i class="fas fa-times"></i> Cancelar Solicitud
                                    </button>
                                    <button id="cancelDocument" class="btn bg-danger btn-app m-0" {$values->doAll}>
                                        <i class="fas fa-ban"></i> Cancelar
                                    </button>
                                    <button id="rateDocument" class="btn btn-app m-0" {$values->doAll}>
                                        <i class="fas fa-search-dollar"></i> Tipo de Cambio
                                    </button>
                                    <button id="upAttach" class="btn btn-app m-0" data-toggle="modal" data-target="#modal-uploadDocument" {$values->doAll}>
                                        <i class="fas fa-file-upload"></i> Subir Cotización
                                    </button>
                                    <button id="addTimeDocument" class="btn btn-app m-0" data-toggle="modal" data-target="#modal-addTime" {$values->doTime}>
                                        <i class="far fa-calendar-plus"></i> + Tiempo 
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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4 class="m-0">
                                            <i class="fas fa-user"></i> Usuario que solicita: {$values->fullname} 
                                        </h4>
                                        <h6 class="mt-3">
                                            Motivo: {$values->justify}
                                        </h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <small class="float-right h6 text-right font-italic">
                                            Fecha de Solicitud: {$values->date} <br>
                                            Fecha ult. actualización: {$values->updated} <br>
                                            Fecha Limite Cierre: {$values->estimated}
                                        </small>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-sm-4">
                                <strong>Moneda:</strong> {$values->currency} <br>
                                <strong>Tipo de Cambio:</strong> <span id="DocumentRate">{$values->rate}</span>
                            </div>
                            <div class="col-sm-4">
                                <strong># Prorrogas:</strong> {$values->extensions} <br>
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
                                <table class="table table-striped" id="productos-requisicion"> 
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Cant.</th>
                                            <th>Producto</th>
                                            <th>U.M</th>
                                            <th>Centro Costo</th>
                                            <th>P. Unitario</th>
                                            <th>Subtotal</th>
                                            <th>Descuento</th>
                                            <th>I.V.A.</th>
                                            <th>O. Imp.</th>
                                            <th>Total</th>
                                            <th>Proveedor</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <p class="lead mb-0">Observaciones del Requisitador:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">{$values->observations}</p>
                            </div>
                            <div class="col-sm-4">
                                <p class="lead">Montos de la requisición</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td class="text-right">$ <span id="DocumentSubtotal"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Descuentos:</th>
                                            <td class="text-right">$ <span id="DocumentDiscount"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Impuestos:</th>
                                            <td class="text-right">$ <span id="DocumentTax"></span></td>
                                        </tr>
                                        <tr class="bg-info">
                                            <th>Total:</th>
                                            <td class="text-right font-weight-bold">$ <span id="DocumentTotal"></span></td>
                                        </tr>
                                        <tr class="bg-success">
                                            <th>Monto Autorizado:</th>
                                            <td class="text-right font-weight-bold">$ <span id="AuthMount"></span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-sm-12 table-responsive">
                                <p class="lead">Cotizaciones de Proveedores:</p>
                                <table class="table table-striped" id="documentos-requisicion">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Documento</th>
                                            <th>Subido por</th>
                                            <th>Fecha de Carga</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
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
                                <table class="table table-striped" id="notas-requisicion">
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

<div class="modal fade" id="modal-rateDocument">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-rateDocument" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Modificar Tipo de Cambio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rate">Ingresa el Tipo de Cambio:</label>
                                <input type="text" name="r_rate" id="r_rate" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <input type="hidden" name="r_rate_uniqid" id="r_rate_uniqid">
                    <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-uploadDocument">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-uploadDocument" enctype="multipart/form-data" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Cargar cotización del proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="r_filename">Especifica el nombre del documento:</label>
                                <input type="text" name="r_filename" id="r_filename" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" name="r_file" id="r_file" class="custom-file-input" accept="application/pdf, application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
                                <label for="r_file" class="custom-file-label">Seleccionar archivo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="submit" class="btn btn-success"><i class="fas fa-upload fa-fw"></i> Subir documento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-addTime">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-addTime" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Añadir prorroga de cierre</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="dtAddTime"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-cancelDocument">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-cancelDocument" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Cancelar Requisición</h5>
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
                    <button type="submit" class="btn btn-danger"><i class="fas fa-times fa-fw"></i> Cancelar Requisición</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-seeObservations">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-seeObservations" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Observaciones del partida</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="m_observations">Observaciones</label>
                                <textarea name="m_observations" id="m_observations" class="form-control" cols="30" rows="4" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editRow">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-editRow" method="post">
                <input type="hidden" name="r_requisition_id" id="r_requisition_id" value="" / >
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Editar Partida: <span id="r_product"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="r_product_edit">Producto</label>
                            <select name="r_product_edit" id="r_product_edit" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="quantity">Cantidad</label>
                                <input type="number" name="r_quantity" id="r_quantity" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="unit_cost">Precio Unitario</label> 
                                <input type="text" name="r_unit_cost" id="r_unit_cost" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="discount">Descuento</label>
                                <input type="text" name="r_discount" id="r_discount" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="subtotal">Subtotal c/Descuento</label>
                                <input type="text" name="r_subtotal" id="r_subtotal" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="tax">I.V.A.</label>
                                <input type="text" name="r_tax" id="r_tax" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="taxes">Otros Impuestos</label>
                                <input type="text" name="r_other_taxes" id="r_other_taxes" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input type="text" name="r_total" id="r_total" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="r_cost_center">Centro de Costo</label>
                            <select name="r_cost_center" id="r_cost_center" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="r_provider">Proveedor</label>
                            <select name="r_provider" id="r_provider" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
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
                    <input type="hidden" name="r_tax_percent" id="r_tax_percent">
                    <input type="hidden" name="r_other_taxes_percent" id="r_tax_percent">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw" ></i> Guardar cambios</button>
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
                    <h5 class="modal-title">Agregar Nota a la Requisición</h5>
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

<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="{$settings['url']}/assets/plugins/moment/moment-with-locales.min.js"></script>
<script src="{$settings['url']}/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="{$settings['url']}/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="{$settings['url']}/assets/ajax/requisiciones-editar.js?v={$v}"></script> 