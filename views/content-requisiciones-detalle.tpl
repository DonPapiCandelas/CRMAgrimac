<div class="content-wrapper">
    <div class="content-header" style="padding: 15px 0.5rem;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-10">
                    <h1 class="m-0 text-dark" style="font-size: 1.8rem; font-weight: 500;">
                        Detalle de la Requisición #{$values->id}
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
                    <div class="mb-3">
                        <div class="row py-3">
                            <div class="col-sm-12">
                                <h4 class="float-left m-0">
                                    <i class="fas fa-user"></i> Usuario que solicita: {$values->fullname} 
                                </h4>
                                <small class="float-right h6 text-right font-italic">
                                    Fecha de Solicitud: {$values->date} <br>
                                    Fecha Limite Cierre: {$values->estimated}
                                </small>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-sm-6">
                                <strong>Proceso:</strong> {$values->state} <br>
                                <strong>Status:</strong> {$values->cancelled} 
                            </div>
                            <div class="col-sm-6">
                                <div id="cancelInfo" class="mt-3">
                                    <strong>Cancelado por:</strong> <span id="cancelledBy">{$values->cancelled_by}</span> <br>
                                    <strong>Fecha cancelación:</strong> {$values->cancelled_date} <br>
                                    <strong>Mótivo cancelación:</strong> {$values->cancelled_text} <br>
                                </div>
                                <strong>Identificador:</strong> <span id="DocumentID">{$values->uniqid}</span> <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <table class="table table-striped" id="productos-requisicion"> 
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Cant.</th>
                                            <th>Producto</th>
                                            <th>U.M.</th>
                                            <th>Centro de Costo</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="lead mb-0">Mis Observaciones:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">{$values->observations}</p>
                            </div>
                        </div>
                        <div class="row mt-5 mb-3">
                            <div class="col-sm-12 table-responsive">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <p class="lead">Comentarios de la Requisición:</p>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-addNote">
                                            <i class="fas fa-plus fa-fw"></i> Agregar comentario
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-striped" id="notas-requisicion">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 10%;">Fecha</th>
                                            <th>Comentario</th>
                                            <th style="width: 10%;">Usuario</th>
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

<div class="modal fade" id="modal-addNote">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" id="form-addNote" method="post">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Agregar comentario a la Requisición</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="rn_observations">Comentario:</label>
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
    <script src="{$settings['url']}/assets/ajax/requisiciones-detalle.js?v={$v}"></script>
</body>
</html>