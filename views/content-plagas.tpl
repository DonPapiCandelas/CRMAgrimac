<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Plagas</h1>
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
                                    <h3 class="card-title">Listado de las plagas registradas en la plataforma.</h3>
                                </div>
                                <div class="text-right col-sm-2">
                                    <a href="#" id="btnAddPlaga" class="btn btn-default text-dark">
                                        <i class="fas fa-plus"></i>
                                        Nueva plaga
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="plagas" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Plaga</th>
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

<div class="modal fade" id="modal-addPlaga">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-addPlaga" method="post">
                <div class="modal-header bg-olive">
                    <h5 class="modal-title">Agregar Plaga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="plaga">Nombre de la Plaga:</label>
                                <input type="text" name="plaga" id="plaga" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/ajax/plagas.js?v={$v}"></script>