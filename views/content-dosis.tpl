<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Dosis</h1>
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
                                    <h3 class="card-title">Listado de los controles de plagas registrados en la plataforma.</h3>
                                </div>
                                <div class="text-right col-sm-2">
                                    <a href="#" id="btnAddDosis" class="btn btn-default text-dark">
                                        <i class="fas fa-plus"></i>
                                        Nueva registro
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="dosis" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Producto</th>
                                        <th>Cultivo</th>
                                        <th>Plaga</th>
                                        <th>Intervalo de Seguridad</th>
                                        <th>Dosis Min</th>
                                        <th>Dosis Max</th>
                                        <th>Dosis Recomendada</th>
                                        <th>USA / MEX</th>
                                        <th></th>
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

<div class="modal fade" id="modal-addDosis">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-addDosis" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Registrar Control de Plagas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="producto">Producto</label>
                            <select name="producto" id="producto" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="cultivo">Cultivo</label>
                            <select name="cultivo" id="cultivo" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="plaga">Plaga</label>
                            <select name="plaga" id="plaga" class="form-control select2" style="width: 100%;" required>
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="intervalo">Intervalo de Seguridad</label>
                            <input type="number" name="intervalo" id="intervalo" min="1" class="form-control" required>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="usa_mex">USA / MEX</label>
                            <select name="usa_mex" id="usa_mex" class="form-control select2" style="width: 100%;" required>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="dosis_min">Dosis Minima</label>
                            <input type="text" name="dosis_min" id="dosis_min" class="form-control" required>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="dosis_max">Dosis Maxima</label>
                            <input type="text" name="dosis_max" id="dosis_max" class="form-control" required>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="dosis_recomendada">Dosis Recomendada</label>
                            <input type="text" name="dosis_recomendada" id="dosis_recomendada" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <input type="hidden" name="control_id" id="control_id" value="0">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="{$settings['url']}/assets/ajax/dosis.js?v={$v}"></script>