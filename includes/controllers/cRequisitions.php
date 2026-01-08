<?php

    class cRequisitions {

        public static array $states = array('Enviado', 'En revisión', 'Cotizando', 'Pendiente de Autorización', 'Autorizada', 'Cancelada', 'No atendida', 'Autorizada Parcialmente', 'Finalizada');

        public function list($type = 0, $candelete = 0): array
        {
            global $user;           
            $requisitions = array();
            $result = null;

            if($type == 0) { // Administrador
                $result = (new mRequisitions)->get();
            } else if($type == 1) { // Requisitador
                $result = (new mRequisitions)->get('user_id = ? AND state != ?', [$user->uniqid, '9']);
            } else if($type == 2) { // Ordenes de Compra  
                $result = (new mRequisitions)->get('state != ?', ['9']);
            } else if($type == 3) { // Autorizador
                $result = (new mRequisitions)->in('state', [2,3,4]);
            }

            foreach ($result as $row) {
                $row->date = (new aCore)->get_stampToDate($row->date);
                $row->estimated = (new aCore)->get_stampToDate($row->estimated);
                $row->authorized_date = ($row->authorized_date > 0) ? (new aCore)->get_stampToDate($row->authorized_date) : 'N/A';
                $row->state = self::$states[$row->state-1];
                $row->candelete = $candelete;

                $userReq = (new cUser)->find($row->user_id);
                $row->fullname = $userReq->fullname;

                $requisitions[] = $row;
            }

            return $requisitions;
        }

        public function listProducts($uniqid): array
        {
            global $user;
            $products = array();

            $result = (new mRequisitions)->getProducts($uniqid);
            foreach($result as $row) {
                $row->tax_percent = 0;
                $row->other_tax_percent = 0;
                $row->can_edit_row = 0;
                $product = (new cProducts)->find($row->product_id);

                if(strpos($product['TaxTypeName'], 'Exento') !== false) {
                    $row->tax_percent = 0;
                } else {
                    $row->tax_percent = 0.16;
                }

                if($user->type == 1 || $user->type == 4) {
                    $row->can_edit_row = 1;
                }

                $provider = (new cProviders)->find($row->provider_id);
                $center = (new cCenters)->find($row->cost_center);
                $row->product = $product['ProductName'];
                $row->cost_center_id = $row->cost_center;
                $row->cost_center = ($row->cost_center > 0) ? $center['CostCenterName'] : 'Sin Asignar';
                $row->provider = ($row->provider_id > 0) ? $provider['BusinessEntity'] : 'Sin Asignar';
                $row->subtotal = ($row->subtotal > 0) ? number_format(($row->subtotal + $row->discount), 5, ".", "") : $row->subtotal;

                $products[] = $row;
            }

            return $products;
        }

        public function listDocuments($uniqid): array
        {
            $documents = array();

            $result = (new mRequisitions)->getDocuments($uniqid);
            foreach($result as $row) {
                $row->date = (new aCore)->get_stampToDate($row->date);
                $userDoc = (new cUser)->find($row ->user_id);
                $row->fullname = $userDoc->fullname;
                $documents[] = $row;
            }

            return $documents;
        }

        public function listNotes($uniqid): array
        {
            $notes = array();

            $result = (new mRequisitions)->getNotes($uniqid);
            foreach($result as $row) {
                $row->date = (new aCore)->get_stampToDate($row->date);
                $userNot = (new cUser)->find($row ->user_id);
                $row->fullname = $userNot->fullname;
                $notes[] = $row;
            }

            return $notes;
        }

        public function find($uniqid) {
            global $user;
            $requisition = (new mRequisitions)->get('uniqid = ?', [$uniqid])[0];
            $requisition->state = self::updateStatus($requisition);

            $requisition->doExport = '';
            $requisition->doAuth = ' disabled';
            $requisition->doTime = 'disabled';

            if($requisition->authorized_by == 0 || $requisition->state == 4) {
                $requisition->doExport = 'disabled';
            }

            if($requisition->cancelled == 1) {
                $requisition->doAll = 'disabled';
                $requisition->doTime = 'disabled';
            } else {
                if($requisition->state == 7) {
                    $requisition->doAll = 'disabled';
                    if($user->type == 1 || $user->type == 4) {
                        $requisition->doTime = '';
                    }
                } else {
                    $requisition->doAll = ($requisition->state > 3) ? 'disabled' :'';
                    $requisition->doTime = 'disabled';
                }
            }

            if($requisition->state == 4 && ($user->type == 1 || $user->type == 4)) {
                $requisition->doAuth = '';
            }

            $userDocument = (new cUser)->find($requisition->user_id);
            $requisition->fullname = $userDocument->fullname;

            $requisition->date = (new aCore)->get_stampToDate($requisition->date);
            $requisition->estimated = (new aCore)->get_stampToDate($requisition->estimated);
            $requisition->updated = (new aCore)->get_stampToDate($requisition->updated_date);
            $requisition->authorized_date = (new aCore)->get_stampToDate($requisition->authorized_date);
            $requisition->state = self::$states[$requisition->state-1];
            $requisition->currency = ($requisition->rate == 1) ? 'MXN' : 'Moneda Extranjera';
            $requisition->cancelled = ($requisition->cancelled == 0) ? 'Vigente' : 'Cancelado';
            
            if($requisition->cancelled_by > 0) {
                $user_cancel = (new cUser)->find($requisition->cancelled_by);
                $requisition->cancelled_by = $user_cancel->fullname;
            }

            if($requisition->authorized_by != 0) {
                $user_auth = (new cUser)->find($requisition->authorized_by);
                $requisition->authorized_by = $user_auth->fullname;
            }

            $requisition->cancelled_date = (new aCore)->get_stampToDate($requisition->cancelled_date);
            
            return $requisition;
        }

        public function authRow($total, $uniqid): array
        {
            global $user;
            $response = array();

            if($total > 0) {
                $data = [
                    'authorized' => 1,
                    'authorized_by' => $user->uniqid,
                    'authorized_date' => time()
                ];
    
                (new mRequisitions)->updateRow($data, 'uniqid', $uniqid);
    
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['code'] = 'No puedes autorizar una partida con importe en ceros';
            }

            return $response;
        }

        public function unauthDoc($uniqid): array
        {
            $response = array();

            $data = [
                'state' => 3,
                'authorized_by' => 0,
                'authorized_date' => 0
            ];

            (new mRequisitions)->update($data, 'uniqid', $uniqid);

            $response['status'] = true;
            return $response;
        }

        public function unauthRow($uniqid): array
        {
            $response = array();

            $data = [
                'authorized' => 2
            ];

            (new mRequisitions)->updateRow($data, 'uniqid', $uniqid);

            $response['status'] = true;
            return $response;
        }

        public function cleanRow($uniqid): array
        {
            $response = array();

            $data = [
                'authorized' => 0,
                'authorized_by' => 0,
                'authorized_date' => 0,
                'unit_cost' => 0,
                'discount' => 0,
                'subtotal' => 0,
                'tax' => 0,
                'total' => 0
            ];

            (new mRequisitions)->updateRow($data, 'uniqid', $uniqid);

            $response['status'] = true;
            return $response;
        }

        public function updateStatus($requisition) {
            global $user;
            $now = time();

            if($requisition->state < 3 && $user->type != 2) {
                if(($now > $requisition->estimated)) {
                    $state = 7;
                } else {
                    if($requisition->state == 1) {
                        $state = 2;
                    } else {
                        $state = $requisition->state;
                    }
                }
    
                $data = [
                    'state' => $state
                ];
    
                (new mRequisitions)->update($data, 'uniqid', $requisition->uniqid);
            } else {
                $state = $requisition->state;
            }

            return $state;
        }

        public function updateLimitTime($uniqid, $timestamp): array
        {
            global $db;

            $response = array();
            $timestamp = strtotime($timestamp);

            $data = [
                'estimated' => $timestamp,
                'state' => 2
            ];

            (new mRequisitions)->update($data, 'uniqid', $uniqid);
            $db->query('UPDATE amac_requisitions SET extensions = extensions + 1 WHERE uniqid = ?', [$uniqid])->exec();

            $response['status'] = true;
            return $response;
        }

        public function updateRow($inputData): array
        {
            $response = array();

            $data = [
                'product_id' => $inputData['r_product_edit'],
                'quantity' => $inputData['r_quantity'],
                'unit_cost' => $inputData['r_unit_cost'],
                'discount' => $inputData['r_discount'],
                'subtotal' => $inputData['r_subtotal'],
                'tax' => $inputData['r_tax'],
                'total' => $inputData['r_total'],
                'cost_center' => $inputData['r_cost_center'],
                'provider_id' => $inputData['r_provider'],
                'observations' => $inputData['r_observations']
            ];

            (new mRequisitions)->updateRow($data, 'uniqid', $inputData['r_uniqid']);

            $data2 = [
                'updated_date' => time()
            ];

            (new mRequisitions)->update($data2, 'uniqid', $inputData['r_requisition_id']);

            $response['status'] = true;
            return $response;
        }

        public function updateRate($inputData): array
        {
            $response = array();

            if($inputData['r_rate'] >= 1) {
                $data = [
                    'rate' => $inputData['r_rate']
                ];
    
                (new mRequisitions)->update($data, 'uniqid', $inputData['r_rate_uniqid']);
    
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['code'] = 'El tipo de cambio debe de ser mayor a cero (Default: 1.00000)';
            }

            return $response;
        }

        public function prepareExport($uniqid): array
        {
            $response = array();

            $data = [
                'exported' => 0
            ];

            (new mRequisitions)->update($data, 'uniqid', $uniqid);
            $response['status'] = true;

            return $response;
        }

        public function cancelDocument($uniqid, $cancelText): array
        {
            global $user;
            $response = array();

            $data = [
                'state' => 6,
                'cancelled' => 1,
                'cancelled_by' => $user->uniqid,
                'cancelled_date' => time(),
                'cancelled_text' => $cancelText
            ];

            (new mRequisitions)->update($data, 'uniqid', $uniqid);
            $response['status'] = true;

            return $response;
        }

        public function authDocument($uniqid): array
        {
            global $db, $settings, $user;
            $response = array();
            (new mRequisitions)->getDocuments($uniqid);
            $rows = (new mRequisitions)->numRows();
            if($rows < $settings['minquotes']) {
                $response['status'] = false;
                $response['code'] = "Falta cargar las cotizaciones de los proveedores. Minimo {$settings['minquotes']} documentos";
            } else {
                $db->table('requisitions_detail')->where('requisition_id = ? AND authorized = ?', [$uniqid, 0])->getAll();
                $rows = (new mRequisitions)->numRows();
                if($rows > 0) {
                    $response['status'] = false;
                    $response['code'] = "Queda(n) $rows fila(s) por autorizar/rechazar";
                } else {
                    $data = [
                        'state' => 4,
                        'authorized_by' => $user->uniqid,
                        'authorized_date' => time()
                    ];
        
                    (new mRequisitions)->update($data, 'uniqid', $uniqid);
                    $response['status'] = true;
                }
            }

            return $response;
        }

        public function confirmAuth($uniqid, $password): array
        {
            global $db, $user;

            $response = array();
            if(hash_equals($user->password, crypt($password, $user->password))) {
                $db->table('requisitions_detail')->where('requisition_id = ?', [$uniqid])->getAll();
                $totalRows = (new mRequisitions)->numRows();
                $db->table('requisitions_detail')->where('requisition_id = ? AND authorized = ?', [$uniqid, 1])->getAll();
                $authRows = (new mRequisitions)->numRows();
                $state = ($totalRows == $authRows) ? 5 : 8;

                $data = [
                    'state' => $state,
                    'authorized_by' => $user->uniqid,
                    'authorized_date' => time()
                ];
    
                (new mRequisitions)->update($data, 'uniqid', $uniqid);
                $response['status'] = true;

            } else {
                $response['status'] = false;
                $response['code'] = "La contraseña ingresada es incorrecta";
            }

            return $response;
        }

        public function DeleteRequisition($uniqid, $password): array
        {
            global $db, $user;

            $response = array();
            if(hash_equals($user->password, crypt($password, $user->password))) {
                (new mRequisitions)->delete_documents($uniqid);
                (new mRequisitions)->delete_notes($uniqid);
                (new mRequisitions)->delete_rows($uniqid);
                (new mRequisitions)->delete($uniqid);
                $response['status'] = true;

            } else {
                $response['status'] = false;
                $response['code'] = "La contraseña ingresada es incorrecta";
            }

            return $response;
        }

        public function seeDocument($uniqid) {
            $document = (new mRequisitions)->getDocument($uniqid);
            if(isset($document->uniqid)) {
                $file = ROOT. '/uploads/documents/requisitions/'. $document->uniqid . $document->extension;
                
                if(file_exists($file)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'. $document->filename .'"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: '. filesize($file));
                    readfile($file);
                }
            }
        }

        public function uploadDocument($filename, $requisition_id, $files) {
            global $user;
            $response = array();

            $uniqid = (new aCore)->new_guid();
            $extension = pathinfo($files['file']['name'], PATHINFO_EXTENSION);
            $filetype = ($extension == 'pdf') ? 'pdf' : 'word';
            $filename_location = $uniqid . '.' . $extension;
            $location = ROOT . '/uploads/documents/requisitions/' . $filename_location;

            $data = [
                'requisition_id' => $requisition_id,
                'date' => time(),
                'filename' => $filename,
                'filetype' => $filetype,
                'extension' => '.' . $extension,
                'user_id' => $user->uniqid,
                'uniqid' => $uniqid
            ];

            if(move_uploaded_file($files['file']['tmp_name'], $location)) {
                $response['status'] = true;

                $requisition = self::find($requisition_id);
                if($requisition->state <= 2) {
                    $rData = [
                        'state' => 3
                    ];

                    (new mRequisitions)->update($rData, 'uniqid', $requisition_id);
                }
                
                (new mRequisitions)->createDocument($data);
            } else {
                $response['status'] = false;
                $response['code'] = 'Ocurrio un error al cargar el documento';
            }

            echo json_encode($response);
        }

        public function deleteDocument($uniqid): array
        {
            $response = array();

            $location = ROOT . '/uploads/documents/requisitions/' . $uniqid . '.*';
            $result = array_map('unlink', glob($location));

            if(array_key_exists(0, $result) && $result[0] == 1) {
                (new mRequisitions)->delete_document($uniqid);
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['code'] = 'Ocurrio un problema al eliminar el documento, por favor intentalo nuevamente';
            }

            return $response;
        }

        public function AgregarRequisicion($productos): array
        {
            global $settings, $user, $db;

            $response = array();

            if(isset($productos['guid'])) {
                //Checar si existe documento con el GUID recibido
                $db->table('requisitions')->where('uniqid = ?', [$productos['guid']])->getAll();
                $totalRows = (new mRequisitions)->numRows();

                if($totalRows == 0) {
                    $estimated = time() + ($settings['max_day_requisitions'] * 86400);
                    $document_uniqid = (new aCore)->new_guid();

                    $data = [
                        'date' => time(),
                        'estimated' => $estimated,
                        'user_id' => $user->uniqid,
                        'state' => 1,
                        'uniqid' => $document_uniqid,
                        'justify' => $productos['justification'],
                        'observations' => $productos['obvs'],
                        'updated_date' => time(),
                    ];

                    $inserted = $db->table('requisitions')->insert($data);
        
                    if($inserted > 0) {
                        $datos = json_decode($productos['data']);
                        
                        foreach ($datos as $key => $value) {
                            $product = (new cProducts)->find($value[1]);
                            $mov = [
                                'requisition_id' => $document_uniqid,
                                'product_id' => $value[1], 
                                'quantity' => $value[4], 
                                'cost_center' => $value[5],
                                'unit' => $product['Unit'],
                                'observations' => $value[7],
                                'uniqid' => (new aCore)->new_guid()
                            ];
                            
                            $db->table('requisitions_detail')->insert($mov);
                        }
                        $response['status'] = true;
                    } else {
                        $response['status'] = false;
                        $response['code'] = 'Ocurrio un problema al enviar la requisicion, por favor intentalo nuevamente';
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
                'requisition_id' => $input['rn_uniqid'],
                'date' => time(),
                'note' => $input['rn_observations'],
                'user_id' => $user->uniqid,
                'uniqid' => $uniqid
            ];

            $inserted = $db->table('requisitions_notes')->insert($data);

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

            (new mRequisitions)->delete_note($uniqid);
            $response['status'] = true;

            return $response;
        }


    }