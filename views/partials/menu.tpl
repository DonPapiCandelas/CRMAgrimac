<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="#" id="gohome" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Inicio</p>
            </a>    
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th-list"></i>
                <p>
                    Catalogos
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{$settings['url']}/clientes" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Clientes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/proveedores" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Proveedores</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/productos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Productos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/servicios" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Servicios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/almacenes" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Almacenes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/centros" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Centros de Costo</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bug"></i>
                <p>
                    Control Plagas
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{$settings['url']}/cultivos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cultivos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/plagas" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Plagas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/dosis" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Control de Dosis</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                    Movimientos
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{$settings['url']}/requisiciones" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Requisiciones</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/insumos" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Insumos</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>
                    Reportes
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{$settings['url']}/reportes/existencias" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Existencias en almacenes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/reportes/inocuidad" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Inocuidad (Auditoria)</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                    Configuración
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{$settings['url']}/parametros" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Parametros</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{$settings['url']}/usuarios" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>