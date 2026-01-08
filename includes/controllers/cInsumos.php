<?php

    class cInsumos {

        public static array $states = array('Enviado', 'En revisión', 'Cancelada', 'Aceptada', 'Autorizada', 'Autorizada Parcialmente', 'Finalizada');

        public function list($type = 0, $can_edit = 0, $candelete = 0): array
        {
            global $user;           
            $insumos = array();
            $result = null;

            if($type == 0) { // Administrador
                $result = (new mInsumos)->get();
            } else if($type == 1) { // Solicitante
                $result = (new mInsumos)->get(['user_id' => $user->uniqid]);
            } 

            foreach ($result as $row) {
                $row->date = (new aCore)->get_stampToDate($row->date);
                $row->authorized_date = ($row->authorized_date > 0) ? (new aCore)->get_stampToDate($row->authorized_date) : 'N/A';
                $row->state = self::$states[$row->state-1];
                $row->canedit = $can_edit;
                $row->candelete = $candelete;

                $userReq = (new cUser)->find($row->user_id);
                $row->fullname = $userReq->fullname;
                $row->fullnameAuth = 'NA';

                if($row->authorized_by != '0') {
                    $userAuth = (new cUser)->find($row->authorized_by);
                    $row->fullnameAuth = $userAuth->fullname;
                }                

                $insumos[] = $row;
            }

            return $insumos;
        }

        public function listProducts($uniqid): array
        {
            global $user;
            $products = array();

            $result = (new mInsumos)->getProducts($uniqid);
            foreach($result as $row) {
                $row->can_edit_row = 0;
                $product = (new cProducts)->find($row->product_id);

                if($user->type == 1 || $user->type == 4) {
                    $row->can_edit_row = 1;
                }

                $center = (new cCenters)->find($row->cost_center);
                $warehouse = (new cWarehouses)->find($row->depot_id);
                $row->product = $product['ProductName'];
                $row->cost_center_id = $row->cost_center;
                $row->ext_product = $product;
                $row->cost_center = ($row->cost_center > 0) ? $center['CostCenterName'] : 'Sin Asignar';
                $row->warehouse = ($row->depot_id > 0) ? $warehouse['DepotName'] : 'Sin Asignar';
                $products[] = $row;
            }

            return $products;
        }

        public function listNotes($uniqid): array
        {
            $notes = array();

            $result = (new mInsumos)->getNotes($uniqid);
            foreach($result as $row) {
                $row->date = (new aCore)->get_stampToDate($row->date);
                $userNot = (new cUser)->find($row ->user_id);
                $row->fullname = $userNot->fullname;
                $notes[] = $row;
            }

            return $notes;
        }

        public function find($uniqid) {
            global $user, $perms;
            
            $permiso = array_search('insumos', array_column($perms, 'module'));

            $insumo = (new mInsumos)->get(['uniqid' => $uniqid])[0];
            $insumo->state = self::updateStatus($insumo);

            $insumo->doExport = '';
            $insumo->doAuth = ' disabled';

            if($insumo->authorized_by == 0) {
                $insumo->doExport = 'disabled';
            }

            if($insumo->cancelled == 1) {
                $insumo->doAll = 'disabled';
            } else {
                $insumo->doAll = ($insumo->state > 2) ? 'disabled' :'';
            }

            if($perms[$permiso]->can_auth == 1 && $insumo->state == 4) {
                $insumo->doAuth = '';
            }

            $userDocument = (new cUser)->find($insumo->user_id);
            $insumo->fullname = $userDocument->fullname;

            $insumo->date = (new aCore)->get_stampToDate($insumo->date);
            $insumo->authorized_date = (new aCore)->get_stampToDate($insumo->authorized_date);
            $insumo->state = self::$states[$insumo->state-1];
            $insumo->cancelled = ($insumo->cancelled == 0) ? 'Vigente' : 'Cancelado';
            
            if($insumo->cancelled_by > 0) {
                $user_cancel = (new cUser)->find($insumo->cancelled_by);
                $insumo->cancelled_by = $user_cancel->fullname;
            }

            if($insumo->authorized_by != 0) {
                $user_auth = (new cUser)->find($insumo->authorized_by);
                $insumo->authorized_by = $user_auth->fullname;
            }

            $insumo->cancelled_date = (new aCore)->get_stampToDate($insumo->cancelled_date);
            
            return $insumo;
        }

        public function authRow($uniqid): array
        {
            global $user;
            $response = array();

            $data = [
                'authorized' => 1,
                'authorized_by' => $user->uniqid,
                'authorized_date' => time()
            ];

            (new mInsumos)->updateRow($data, 'uniqid', $uniqid);

            $response['status'] = true;

            return $response;
        }

        public function unauthRow($uniqid): array
        {
            $response = array();

            $data = [
                'authorized' => 2
            ];

            (new mInsumos)->updateRow($data, 'uniqid', $uniqid);

            $response['status'] = true;
            return $response;
        }

        public function updateStatus($insumo) {
            global $user;

            if($insumo->state < 3 && $user->uniqid != $insumo->user_id) {
                if($insumo->state == 1) {
                    $state = 2;
                } else {
                    $state = $insumo->state;
                }
    
                $data = [
                    'state' => $state
                ];
    
                (new mInsumos)->update($data, 'uniqid', $insumo->uniqid);
            } else {
                $state = $insumo->state;
            }

            return $state;
        }

        public function productStock($input) {
            return (new mWarehouses)->stock($input['productID'], $input['depotID']);
        }

        public function updateRow($inputData): array
        {
            $response = array();

            $product = (new cProducts)->find($inputData['r_product_id_select']);

            $data = [
                'quantity' => $inputData['r_quantity'],
                'product_id' => $inputData['r_product_id_select'],
                'unit' => $product['Unit'],
                'cost_center' => $inputData['r_cost_center'],
                'depot_id' => $inputData['r_depot_id'],
                'lote' => $inputData['r_lote'],
                'caducidad' => $inputData['r_caducidad'],
                'observations' => $inputData['r_observations']
            ];

            (new mInsumos)->updateRow($data, 'uniqid', $inputData['r_uniqid']);
            $response['status'] = true;
            return $response;
        }

        public function prepareExport($uniqid): array
        {
            $response = array();

            $data = [
                'exported' => 0
            ];

            (new mInsumos)->update($data, 'uniqid', $uniqid);
            $response['status'] = true;

            return $response;
        }

        public function cancelDocument($uniqid, $cancelText): array
        {
            global $user;
            $response = array();

            $data = [
                'state' => 3,
                'cancelled' => 1,
                'cancelled_by' => $user->uniqid,
                'cancelled_date' => time(),
                'cancelled_text' => $cancelText
            ];

            (new mInsumos)->update($data, 'uniqid', $uniqid);
            $response['status'] = true;

            return $response;
        }

        public function authDocument($uniqid): array
        {
            $response = array();
            
            $data = [
                'state' => 4
            ];

            (new mInsumos)->update($data, 'uniqid', $uniqid);
            $response['status'] = true;

            return $response;
        }

        public function confirmAuth($uniqid, $password): array
        {
            global $db, $user;

            $response = array();

            $db->table('insumos_detail')->where('insumo_id = ? AND authorized = ?', [$uniqid, 0])->getAll();
            $rows = (new mInsumos)->numRows();
            if($rows > 0) {
                $response['status'] = false;
                $response['code'] = "Queda(n) $rows fila(s) por autorizar/rechazar";
            } else {
                $db->table('insumos_detail')->where('insumo_id = ? AND depot_id = ? AND authorized NOT IN(1,2)', [$uniqid, 0])->getAll();
                $rows = (new mInsumos)->numRows();
                if($rows > 0) {
                    $response['status'] = false;
                    $response['code'] = "$rows fila(s) no tienen asignado un almacen";
                } else {
                    if(hash_equals($user->password, crypt($password, $user->password))) {
                        $db->table('insumos_detail')->where('insumo_id = ?', [$uniqid])->getAll();
                        $totalRows = (new mInsumos)->numRows();
                        $db->table('insumos_detail')->where('insumo_id = ? AND authorized = ?', [$uniqid, 1])->getAll();
                        $authRows = (new mInsumos)->numRows();
                        $state = ($totalRows == $authRows) ? 5 : 6;
        
                        $data = [
                            'state' => $state,
                            'authorized_by' => $user->uniqid,
                            'authorized_date' => time()
                        ];
            
                        (new mInsumos)->update($data, 'uniqid', $uniqid);
                        $response['status'] = true;
        
                    } else {
                        $response['status'] = false;
                        $response['code'] = "La contraseña ingresada es incorrecta";
                    }
                }
            }

            return $response;
        }

        public function DeleteInsumo($uniqid, $password): array
        {
            global $db, $user;

            $response = array();
            if(hash_equals($user->password, crypt($password, $user->password))) {
                (new mInsumos)->delete_notes($uniqid);
                (new mInsumos)->delete_rows($uniqid);
                (new mInsumos)->delete($uniqid);
                $response['status'] = true;

            } else {
                $response['status'] = false;
                $response['code'] = "La contraseña ingresada es incorrecta";
            }

            return $response;
        }

        public function AgregarInsumo($productos): array
        {
            global $settings, $user, $db;

            $response = array();

            if(isset($productos['guid'])) {
                //Checar si existe documento con el GUID recibido
                $db->table('insumos')->where('uniqid = ?', [$productos['guid']])->getAll();
                $totalRows = (new mInsumos)->numRows();

                if($totalRows == 0) {
                    $document_uniqid = (new aCore)->new_guid();

                    $data = [
                        'date' => time(),
                        'user_id' => $user->uniqid,
                        'state' => 1,
                        'uniqid' => $document_uniqid,
                        'justify' => $productos['justification'],
                        'observations' => $productos['obvs']
                    ];

                    $inserted = $db->table('insumos')->insert($data);
                    //$inserted = 1;    

                    if($inserted > 0) {
                        $datos = json_decode($productos['data']);
                        
                        foreach ($datos as $key => $value) {
                            $mov = [
                                'insumo_id' => $document_uniqid,
                                'product_id' => $value->CodigoProducto, 
                                'quantity' => $value->Cantidad, 
                                'cost_center' => $value->CveCentroCosto,
                                'unit' => $value->UnidadMedida,
                                'plaga' => $value->Plaga,
                                'dosis_hectarea' => $value->DosisHectarea,
                                'dosis_tambo' => $value->DosisTambo,
                                'ph' => $value->PH,
                                'valvula' => $value->Valvula,
                                'drenaje' => $value->Drenaje,
                                'conductividad' => $value->Conductividad,
                                'observations' => $value->Observaciones,
                                'uniqid' => (new aCore)->new_guid()
                            ];
                            
                            $db->table('insumos_detail')->insert($mov);
                        }
                        $response['status'] = true;
                    } else {
                        $response['status'] = false;
                        $response['code'] = 'Ocurrio un problema al enviar la solicitud de salida de insumo, por favor intentalo nuevamente';
                    }
                } else {
                    $response['status'] = true;
                }
            } else {
                $response['status'] = false;
                $response['code'] = "Por favor elimine el historial de navegación de su dispositivo e intentelo nuevamente";
            }      
            
            return $response;
        }

        public function AgregarNota(): array
        {
            global $user, $input, $db;
            $response = array();

            $uniqid = (new aCore)->new_guid();

            $data = [
                'insumo_id' => $input['rn_uniqid'],
                'date' => time(),
                'note' => $input['rn_observations'],
                'user_id' => $user->uniqid,
                'uniqid' => $uniqid
            ];

            $inserted = $db->table('insumos_notes')->insert($data);

            if($inserted > 0) {
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['code'] = 'Ocurrio un error al guardar la nota';
            }

            return $response;
        }

        public function EliminarNota($uniqid): array
        {
            $response = array();

            (new mInsumos)->delete_note($uniqid);
            $response['status'] = true;

            return $response;
        }


    }