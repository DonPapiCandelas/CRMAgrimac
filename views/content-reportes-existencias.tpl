<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Reportes de existencias en almacenes</h1>
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
                                    <h3 class="card-title">Detalle de las existencias por producto y por almacen</h3>
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
                            <table id="existencias" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Clave</th>
                                        <th>Producto</th>
                                        <th>Almacen</th>
                                        <th>Disponible</th>
                                        <th>Unidad Medida</th>
                                        <!--<th>Minimo</th>
                                        <th>Maximo</th>-->
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

<script src="{$settings['url']}/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{$settings['url']}/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{$settings['url']}/assets/ajax/reportes/existencias.js?v={$v}"></script>