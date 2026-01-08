<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-10">
                    <h1 class="m-0 text-dark" style="font-size: 1.8rem; font-weight: 500;">
                        Realizar nueva requisición
                    </h1>
                </div>
                <div class="col-sm-2">
                    <a href="{$settings['url']}/requisiciones" class="btn btn-primary float-right">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h6 class="m-0 p-3 bg-primary text-white">Detalle de productos a solicitar</h6>
                    <div class="row m-0 py-3 bg-light">
                        <div class="col-sm-12">
                            <label for="justification-document">Justificacion de la Requisición:</label>
                            <textarea name="justification-document" id="justification-document" cols="30" rows="2" class="form-control" required></textarea>
                        </div>
                    </div>
                    <form action="" id="AgregarProductos" method="post" autocomplete="off" class="px-3 py-3 bg-light">
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="product">Producto</label>
                                <select name="product" id="product" class="form-control select2" required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-sm-1">
                                <label for="quantity">Cantidad</label>
                                <input type="number" name="quantity" id="quantity" min="1" step="1" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" required>
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="cost_center">Centro de Costo</label>
                                <select name="cost_center" id="cost_center" class="form-control select2" required>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="observations">Observaciones</label>
                                <input type="text" name="observations" id="observations" maxlength="25" class="form-control">
                            </div>
                            <div class="form-group col-sm-1 align-self-center text-center">
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus fa-fw"></i>Agregar
                                </button>
                            </div>
                        </div>
                    </form>
    
                    <table class="table table-stripped" id="DetalleProductos">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center"># Partida</th>
                                <th class="text-center">Codigo Producto</th>
                                <th class="text-center">Nombre Producto</th>
                                <th class="text-center">Unidad de Medida</th>
                                <th class="text-center">Cantidad Solicitada</th>
                                <th class="text-center">Clave Centro Costo</th>
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
                                <i class="fas fa-save fa-fw"></i> Enviar requisición
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
<script src="{$settings['url']}/assets/ajax/requisiciones-agregar.js?v={$v}"></script>