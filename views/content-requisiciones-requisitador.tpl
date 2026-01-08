<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Listado de Requisiciones</h1>
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
                                    <h3 class="card-title">Listado de las requisiciones registradas en la plataforma.</h3>
                                </div>
                                <div class="text-right col-sm-2">
                                    <a href="{$settings['url']}/requisiciones/agregar" class="btn btn-default text-dark">
                                        <i class="fas fa-plus"></i>
                                        Nueva requisición
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="requisiciones" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Solicitado</th>
                                        <th>Límite Cierre</th>
                                        <th>Cierre</th>
                                        <th>Requisitador</th>
                                        <th>Status</th>
                                        <th>Proceso</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            
<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/ajax/requisiciones-requisitador.js?v={$v}"></script>