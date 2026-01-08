<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Clientes</h1>
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
                                <div class="text-left col-sm-12 align-self-center">
                                    <h3 class="card-title">Listado de los clientes registrados en la plataforma.</h3>
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
                            <table id="clientes" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Empresa</th>
                                        <th>Moneda</th>
                                        <th>Límite de Crédito</th>
                                        <th>Uso del CFDI</th>
                                        <th>Método de Pago</th>
                                        <th>Forma de Pago</th>
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
<script src="{$settings['url']}/assets/ajax/clientes.js?v={$v}"></script>