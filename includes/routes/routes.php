<?php

    // ----------------------------------------------------------------
    
    $router->get('/', function() {
        global $user, $router;

        if($user->type == 2 || $user->type == 3 || $user->type == 4) {
            header('Location: ' . $router->base_path . '/requisiciones'); 
            
        } else {
            (new aViews)->make('index', 'AgriMAC');
        }
    });

    $router->get('/actualizar', function() {
        (new mUpdate101)->Inicializar();
    });

    #region Clientes
    $router->get('/clientes', function() {
        global $perms, $router;
        $index = array_search('clients', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('clientes', 'Listado de Clientes') : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/clientes/listar', function() {
        global $perms, $router;
        $index = array_search('clients', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cClients)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });
    #endregion

    #region Proveedores
    $router->get('/proveedores', function() {
        global $perms, $router;
        $index = array_search('providers', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('proveedores', 'Listado de Proveedores') : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/proveedores/listar', function() {
        global $perms, $router;
        $index = array_search('providers', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cProviders)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });
    #endregion

    #region Productos
    $router->get('/productos', function() {
        global $perms, $router;
        $index = array_search('products', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('productos', 'Listado de Productos') : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/productos/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        echo json_encode((new cProducts)->find($uniqid));
    });

    $router->post('/productos/listar', function() {
        global $perms, $router;
        $index = array_search('products', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cProducts)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });
    #endregion

    #region Servicios
    $router->get('/servicios', function() {
        global $perms, $router;
        $index = array_search('services', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('servicios', 'Listado de Servicios') : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/servicios/listar', function() {
        global $perms, $router;
        $index = array_search('services', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cServices)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });
    #endregion

    #region Almacenes
    $router->get('/almacenes', function() {
        global $perms, $router;
        $index = array_search('warehouses', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('almacenes', 'Listado de almacenes') : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/almacenes/listar', function() {
        global $perms, $router;
        $index = array_search('warehouses', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cWarehouses)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });
    #endregion

    #region Centros de Costo
    $router->get('/centros', function() {
        global $perms, $router;
        $index = array_search('centers', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('centros', 'Listado de Centros de Costo') : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/centros/listar', function() {
        global $perms, $router;
        $index = array_search('centers', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cCenters)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });
    #endregion

    #region Requisiciones
    $router->get('/requisiciones', function() {
        global $user, $perms, $router;
    
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($user->type == 1) { //Administrador
            ($perms[$index]->can_view == 1) ? (new aViews)->make('requisiciones-administrador', 'Detalle de Requisiciones') : header('Location: ' . $router->base_path . '/403');
        } else if($user->type == 2) { // Requisitador
            // ($perms[$index]->can_view == 1) ? aViews::requisitador() : header('Location: ' . $router->base_path . '/403');
            ($perms[$index]->can_view == 1) ? (new aViews)->make('requisiciones-requisitador', 'Detalle de Requisiciones') : header('Location: ' . $router->base_path . '/403');
        } else if($user->type == 3) { // Manejador de Ordenes de Compra
            ($perms[$index]->can_view == 1) ? (new aViews)->make('requisiciones-ordenes-compra', 'Detalle de Requisiciones') : header('Location: ' . $router->base_path . '/403');
        } else if($user->type == 4) { // Autorizador de Ordenes de Compra
            ($perms[$index]->can_view == 1) ? (new aViews)->make('requisiciones-autorizador', 'Detalle de Requisiciones') : header('Location: ' . $router->base_path . '/403');
        }
    });

    $router->post('/requisiciones/listar', function() {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cRequisitions)->list(0, $perms[$index]->can_delete));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/listar/ordenes', function() {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cRequisitions)->list(2));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/listar/autorizar', function() {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cRequisitions)->list(3));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/listar/requisitador', function() {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cRequisitions)->list(1));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/requisiciones/editar/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router; 
        $index = array_search('requisitions', array_column($perms, 'module'));
        $request = (new cRequisitions)->find($uniqid);
        ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) ? (new aViews)->make('requisiciones-editar', 'Editar Requisición', $request) : header('Location: ' . $router->base_path . '/403');
    });

    $router->get('/requisiciones/detalle/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router; 
        $index = array_search('requisitions', array_column($perms, 'module'));
        $request = (new cRequisitions)->find($uniqid);
        ($perms[$index]->can_view == 1) ? (new aViews)->make('requisiciones-detalle', 'Detalle Requisición', $request) : header('Location: ' . $router->base_path . '/403');
    });

    $router->get('/requisiciones/agregar', function() {
        global $perms, $router; 
        $index = array_search('requisitions', array_column($perms, 'module'));
        $GUID = (new aCore)->new_guid();
        ($perms[$index]->can_view == 1 && $perms[$index]->can_add == 1) ? (new aViews)->make('requisiciones-agregar', 'Agregar Requisición', $GUID) : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/requisiciones/editar/partida', function() {
        global $perms, $router, $input;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->updateRow($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/limpiar-fila/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->cleanRow($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/autorizar-fila/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router, $input;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->authRow($input['total'], $uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/rechazar/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->unauthDoc($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/rechazar-fila/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->unauthRow($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/productos/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cRequisitions)->listProducts($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/documentos/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->listDocuments($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/ver-documento/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            (new cRequisitions)->seeDocument($uniqid);
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/subir-documento', function() {
        global $perms, $router, $input;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            (new cRequisitions)->uploadDocument($input['filename'], $input['requisition_id'], $_FILES);
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/agregar/nota', function() {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_add == 1) {
            echo json_encode((new cRequisitions)->AgregarNota());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/eliminar-nota/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1 && $perms[$index]->can_delete == 1) {
            echo json_encode((new cRequisitions)->EliminarNota($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/notas/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->listNotes($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/eliminar-documento/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1 && $perms[$index]->can_delete == 1) {
            echo json_encode((new cRequisitions)->deleteDocument($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/prorroga/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router, $input;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->updateLimitTime($uniqid, $input['newdate']));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        } 
    });

    $router->post('/requisiciones/cancelar/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router, $input;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->cancelDocument($uniqid, $input['canceltext']));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/tipo-cambio', function() {
        global $perms, $router, $input;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->updateRate($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/autorizar-documento/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->authDocument($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/requisiciones/confirmar-autorizacion/([a-fA-F0-9\-\ ]+)/(.*)', function($uniqid, $password) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cRequisitions)->ConfirmAuth($uniqid, $password));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/requisiciones/eliminar-requisicion/([a-fA-F0-9\-\ ]+)/(.*)', function($uniqid, $password) {
        global $perms, $router;
        $index = array_search('requisitions', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_delete == 1) {
            echo json_encode((new cRequisitions)->DeleteRequisition($uniqid, $password));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/requisiciones/productos', function() {
        echo json_encode((new cProducts)->list());
    });

    $router->post('/requisiciones/centros', function() {
        echo json_encode((new cCenters)->list());
    });

    $router->post('/requisiciones/proveedores', function() {
        echo json_encode((new cProviders)->list());
    });

    $router->post('/requisiciones/exportar/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        echo json_encode((new cRequisitions)->prepareExport($uniqid));
    });

    $router->post('/requisiciones/exportarComercial/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        $exe = ROOT . '/bin/ConnectorPro.exe ' . $uniqid;
        echo shell_exec($exe);
    });

    $router->post('/requisiciones/agregar', function() {
        global $input;
        global $perms, $router; 
        $index = array_search('requisitions', array_column($perms, 'module'));
        
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_add == 1) {
            echo json_encode((new cRequisitions)->AgregarRequisicion($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });
    #endregion

    #region Insumos
    $router->get('/insumos', function() {
        global $perms, $router;
    
        $index = array_search('insumos', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('insumos', 'Detalle de Insumos') : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/insumos/listar', function() {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cInsumos)->list(0, $perms[$index]->can_edit, $perms[$index]->can_delete));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/insumos/detalle/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router; 
        $index = array_search('insumos', array_column($perms, 'module'));
        $request = (new cInsumos)->find($uniqid);
        ($perms[$index]->can_view == 1) ? (new aViews)->make('insumos-detalle', 'Detalle Salida', $request) : header('Location: ' . $router->base_path . '/403');
    });

    $router->get('/insumos/editar/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router; 
        $index = array_search('insumos', array_column($perms, 'module'));
        $request = (new cInsumos)->find($uniqid);
        ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) ? (new aViews)->make('insumos-editar', 'Editar Salida', $request) : header('Location: ' . $router->base_path . '/403');
    });

    $router->get('/insumos/agregar', function() {
        global $perms, $router; 
        $index = array_search('insumos', array_column($perms, 'module'));
        $GUID = (new aCore)->new_guid();
        ($perms[$index]->can_view == 1 && $perms[$index]->can_add == 1) ? (new aViews)->make('insumos-agregar', 'Agregar Salida', $GUID) : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/insumos/agregar', function() {
        global $input;
        global $perms, $router; 
        $index = array_search('insumos', array_column($perms, 'module'));
        
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_add == 1) {
            echo json_encode((new cInsumos)->AgregarInsumo($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/editar/partida', function() {
        global $perms, $router, $input;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cInsumos)->updateRow($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/productos/existencias', function() {
        global $perms, $router, $input;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cInsumos)->productStock($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/autorizar-fila/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cInsumos)->authRow($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/rechazar-fila/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cInsumos)->unauthRow($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/productos/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cInsumos)->listProducts($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/agregar/nota', function() {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cInsumos)->AgregarNota());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/eliminar-nota/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1 && $perms[$index]->can_delete == 1) {
            echo json_encode((new cInsumos)->EliminarNota($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/notas/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1) {
            echo json_encode((new cInsumos)->listNotes($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/cancelar/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router, $input;
        $index = array_search('insumos', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cInsumos)->cancelDocument($uniqid, $input['canceltext']));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/autorizar-documento/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cInsumos)->authDocument($uniqid));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/insumos/confirmar-autorizacion/([a-fA-F0-9\-\ ]+)/(.*)', function($uniqid, $password) {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cInsumos)->ConfirmAuth($uniqid, $password));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/insumos/eliminar-requisicion/([a-fA-F0-9\-\ ]+)/(.*)', function($uniqid, $password) {
        global $perms, $router;
        $index = array_search('insumos', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_delete == 1) {
            echo json_encode((new cInsumos)->DeleteInsumo($uniqid, $password));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/insumos/productos', function() {
        echo json_encode((new cProducts)->list());
    });

    $router->post('/insumos/centros', function() {
        echo json_encode((new cCenters)->list());
    });

    $router->post('/insumos/almacenes', function() {
        echo json_encode((new cWarehouses)->list());
    });

    $router->post('/insumos/exportar/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        echo json_encode((new cInsumos)->prepareExport($uniqid));
    });

    $router->post('/insumos/exportarComercial/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        $exe = ROOT . '/bin/ConnectorProSalidas.exe ' . $uniqid;
        echo shell_exec($exe);
    });
    #endregion 

    #region Control de Pladas
    $router->get('/cultivos', function() {
        global $perms, $router; 
        $index = array_search('users', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('cultivos', 'Control de Cultivos') : header('Location: ' . $router->base_path . '/403'); 
    });

    $router->post('/cultivos/listar', function() {
        global $perms, $router; 
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cCultivos)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/cultivos/agregar', function() {
        global $perms, $router, $input; 
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cCultivos)->add($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/plagas', function() {
        global $perms, $router; 
        $index = array_search('users', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('plagas', 'Control de Plagas') : header('Location: ' . $router->base_path . '/403'); 
    });

    $router->post('/plagas/listar', function() {
        global $perms, $router; 
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cPlagas)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/plagas/agregar', function() {
        global $perms, $router, $input; 
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cPlagas)->add($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/dosis', function() {
        global $perms, $router; 
        $index = array_search('users', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('dosis', 'Control de Dosis en Plagas') : header('Location: ' . $router->base_path . '/403'); 
    });

    $router->post('/dosis/listar', function() {
        global $perms, $router; 
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cDosis)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/dosis/agregar', function() {
        global $perms, $router, $input; 
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cDosis)->add($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->post('/dosis/actualizar', function() {
        global $perms, $router, $input; 
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cDosis)->update($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    #endregion

    #region Parametros
    $router->get('/parametros', function() {
        global $perms, $settings, $router;
        $index = array_search('params', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('parametros', 'Configuración del Sistema', $settings) : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/parametros/actualizar', function() {
        global $perms, $router, $input;
        $index = array_search('params', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cParams)->update($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        } 
    });
    #endregion

    #region Usuarios
    $router->get('/usuarios', function() {
        global $perms, $router; 
        $index = array_search('users', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1) ? (new aViews)->make('usuarios', 'Listado de Usuarios') : header('Location: ' . $router->base_path . '/403');      
    });

    $router->post('/usuarios/listar', function() {
        global $perms, $router;
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cUser)->list());
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        }
    });

    $router->get('/usuarios/agregar', function() {
        global $perms, $router;
        $index = array_search('users', array_column($perms, 'module'));
        ($perms[$index]->can_view == 1 && $perms[$index]->can_add == 1) ? (new aViews)->make('usuarios-agregar', 'Registrar Usuario') : header('Location: ' . $router->base_path . '/403');  
    });

    $router->post('/usuarios/agregar', function() {
        global $perms, $router, $input;
        $index = array_search('users', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_add == 1) {
            echo json_encode((new cUser)->add($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        } 
    });

    $router->get('/usuarios/editar/([a-fA-F0-9\-\ ]+)', function($uniqid) {
        global $perms, $router; 
        $index = array_search('users', array_column($perms, 'module'));
        $request = (new cUser)->find($uniqid);
        
        ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) ? (new aViews)->make('usuarios-editar', 'Editar Usuario', $request) : header('Location: ' . $router->base_path . '/403');
    });

    $router->post('/usuarios/editar', function() {
        global $perms, $router, $input;
        $index = array_search('users', array_column($perms, 'module'));
        if ($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cUser)->update($input));
        } else {
            header('Location: ' . $router->base_path . '/403'); 
        } 
    });

    $router->post('/usuarios/permisos', function() {
        global $perms, $router, $input;
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cUser)->permissions($input['uniqid']));
        } else {
            header('Location: ' . $router->base_path . '/403');
        }  
    });

    $router->post('/usuarios/permisos/actualizar', function() {
        global $perms, $router, $input;
        $index = array_search('users', array_column($perms, 'module'));
        if($perms[$index]->can_view == 1 && $perms[$index]->can_edit == 1) {
            echo json_encode((new cUser)->update_permissions($input, $input['p_user_id'], $input['p_permission_id']));
        } else {
            header('Location: ' . $router->base_path . '/403');
        } 
    });
    #endregion 

    #region Inicio de Sesión
    $router->get('/login', function() {
        (new aViews)->login();
    });

    $router->post('/login', function() {
        echo json_encode((new cUser)->login());
    });

    $router->get('/logout', function() {
        (new cUser)->logout();
    });
    #endregion

    #region Reportes
    $router->get('/reportes/existencias', function() {
        (new aViews)->make('reportes-existencias', 'Reportes');
    });

    $router->post('/reportes/existencias/listar', function() {
        echo json_encode((new mWarehouses)->stock());
    });

    $router->get('/reportes/inocuidad', function() {
        (new aViews)->make('reportes-inocuidad', 'Reportes');
    });

    $router->post('/reportes/inocuidad', function() {
        echo json_encode((new cWarehouses)->inocuidad());
    });

    $router->get('/reportes/inocuidad/imprimir', function() {
        (new aViews)->static('reportes-inocuidad-impresion', 'Reportes');
    });
    #endregion

    #region Control de Errores
    $router->get('/403', function() {
        header($_SERVER['SERVER_PROTOCOL'] . "403 Forbidden");
        (new aViews)->make('403', 'Sin autorización');
    });

    $router->add('/.*', function() {
        header($_SERVER['SERVER_PROTOCOL'] . "404 Not Found");
        (new aViews)->make('404', 'Módulo no encontrado');
    });
    #endregion


    $router->route();