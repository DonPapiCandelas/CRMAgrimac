<div class="content-wrapper bg-white">
    <div class="content-header" style="padding: 15px 0.5rem;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-10">
                    <h1 class="m-0 text-dark" style="font-size: 1.8rem; font-weight: 500;">
                        Solicitud de salida de insumo
                    </h1>
                </div>
                <div class="col-sm-2">
                    <a href="{$settings['url']}/insumos" class="btn btn-primary float-right">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="content" style="padding: 0 0.5rem">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h6 class="m-0 p-3 bg-primary text-white">Detalle de productos a solicitar</h6>
                    <div class="row m-0 py-3 bg-light">
                        <div class="col-sm-12">
                            <label for="justification-document">Justificacion de la Salida de Insumos:</label>
                            <textarea name="justification-document" id="justification-document" cols="30" rows="2" class="form-control" required></textarea>
                        </div>
                    </div>
                    <form action="" id="AgregarProductos" method="post" autocomplete="off" class="px-3 py-3 bg-light">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="product">Producto*</label>
                                <select name="product" id="product" class="form-control select2" required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-sm-1">
                                <label for="quantity">Cantidad*</label>
                                <input type="number" name="quantity" id="quantity" min="1" step="0.01" class="form-control" required>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="cost_center">Centro de Costo*</label>
                                <select name="cost_center" id="cost_center" class="form-control select2" required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="observations">Observaciones</label>
                                <input type="text" name="observations" id="observations" maxlength="25" class="form-control">
                            </div>
                            <div class="form-group col-sm-1 align-self-center text-center">
                                <button type="button" id="bContinuar" class="btn btn-sm btn-success">
                                    <i class="fas fa-angle-double-right fa-fw"></i> Continuar
                                </button>
                            </div>
                        </div>
                        <div class="modal fade" id="modalAdicional" tabindex="-1" role="dialog" aria-labelledby="modalAdicionalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-olive">
                                        <h5 class="modal-title" id="modalAdicionalLabel">¿Deseas agregar la siguiente informacion?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="plaga">Plaga:</label>
                                                    <input type="text" name="plaga" id="plaga" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="dosis_hectarea">Dosis por Hectarea:</label>
                                                    <input type="text" name="dosis_hectarea" id="dosis_hectarea" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="dosis_tambo">Dosis por Tambo:</label>
                                                    <input type="text" name="dosis_tambo" id="dosis_tambo" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="ph">PH:</label>
                                                    <input type="text" name="ph" id="ph" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="valvula">Valvula:</label>
                                                    <input type="text" name="valvula" id="valvula" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="drenaje">Drenaje:</label>
                                                    <input type="text" name="drenaje" id="drenaje" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="conductividad">Conductividad:</label>
                                                    <input type="text" name="conductividad" id="conductividad" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save fa-fw"></i> Guardar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-stripped" id="DetalleProductos">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Unidad de Medida</th>
                                <th class="text-center">Centro Costo</th>
                                <th class="text-center">Observaciones</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                    </table>

                    <div class="row">
                        <div class="col-sm-10">
                            <label for="observations-document">Añadir observaciones generales</label>
                            <textarea name="observations-document" id="observations-document" cols="30" rows="3" class="form-control"></textarea>
                            <input type="hidden" name="GUID" id="GUID" value="{$values}">
                        </div>
                        <div class="col-sm-2 align-self-center text-center">
                            <button id="EnviarDocumento" class="btn btn-sm btn-success">
                                <i class="fas fa-save fa-fw"></i> Enviar solicitud
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="{$settings['url']}/assets/ajax/insumos-agregar.js?v={$v}"></script>