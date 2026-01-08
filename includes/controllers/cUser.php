<?php

    class cUser {

        public function get_user_session() {
            global $cookies;

            if(isset($cookies['loginkey'])) {
                return (new mUser)->get('loginkey', $cookies['loginkey']);
            } else {
                return null;
            }
        }

        public function get_user_permissions($user_id) {
            return (new mUser)->permissions($user_id);
        }

        public function updateTime() {
            global $user;

            if($user instanceof stdClass) {
                $data = [
                    'lastactivity' => time()
                ];

                (new mUser)->update($data, 'uniqid', $user->uniqid);
            }
        }

        public function login(): array
        {
            global $input;

            $response = array();
            $user = (new mUser)->get('username', $input['username']);

            if($user instanceof stdClass) {
                if(hash_equals($user->password, crypt($input['password'], $user->password))) {
                    if($user->state == 1) {
                        $loginkey = (new aCore)->random_key(32);
                        
                        $data = [
                            'lastlogin' => time(), 
                            'loginkey' => $loginkey,
                            'lastlongip' => (new aCore)->my_inet_ntop((new aCore)->get_ip())
                        ];
                        
                        (new mUser)->update($data, 'uniqid', $user->uniqid);
                        (new aCore)->my_set_cookie('loginkey', $loginkey);
                        $response['status'] = true;
                    } else {
                        $response['status'] = false;
                        $response['code'] = "El usuario se encuentra deshabilitado.";
                    }
                } else {
                    $response['status'] = false;
                    $response['code'] = "La contraseña ingresada es incorrecta.";
                }
            } else {
                $response['status'] = false;
                $response['code'] = "El usuario y/o contraseña ingresados son incorrectos.";
            }

            return $response;
        }

        public function logout() {
            global $settings;

            (new aCore)->my_unset_cookie('loginkey');
            header('Location: '. $settings['url']);
        }

        public function list(): array
        {
            $users = array();
            $types = array('Administrador', 'Requisitador', 'Manejo de Ordenes de Compra', 'Autorizador de Ordenes');

            $result = (new mUser)->get(null, null, true);
            foreach($result as $row) {
                $row->lastactivity = ($row->lastactivity > 0) ? (new aCore)->get_stampToDate($row->lastactivity) : 'S/D';
                $row->lastlogin = ($row->lastlogin > 0) ? (new aCore)->get_stampToDate($row->lastlogin) : 'S/D';
                $row->register = (new aCore)->get_stampToDate($row->register);
                $row->email = (new aCore)->encrypt_decrypt($row->email, 'decrypt');
                $row->type = $types[$row->type-1];
                $users[] = $row;
            }

            return $users;
        }

        public function find($uniqid) {
            $user = array();
            $user = (new mUser)->get('uniqid', $uniqid);

            $user->lastlogin = (new aCore)->get_stampToDate($user->lastlogin);
            $user->register = (new aCore)->get_stampToDate($user->register);
            $user->lastactivity = (new aCore)->get_stampToDate($user->lastactivity);
            $user->email = (new aCore)->encrypt_decrypt($user->email, 'decrypt');
            $user->state = ($user->state == 1) ? 'checked' : '';

            return $user;
        }

        public function add($data): array
        {
            global $db;
            $response = array();
            $modules = array('users', 'params', 'clients', 'providers', 'products', 'services', 'centers', 'requisitions', 'reports', 'insumos', 'insumos-aplicaciones');
            $permissions = array('can_view' => 0, 'can_add' => 0, 'can_edit' => 0, 'can_delete' => 0, 'can_auth' => 0);

            $uniqid = (new aCore)->new_guid();
            $data['register'] = time();
            $data['state'] = ($data['state'] == 'on') ? 1 : 0;
            $data['uniqid'] = $uniqid;
            $data['email'] = (new aCore)->encrypt_decrypt($data['email'], 'encrypt');
            $data['password'] = (new aCore)->crypt_password($data['password']);
            unset($data['confirm-password']);
            
            $inserted = $db->table('users')->insert($data);

            if($inserted > 0) {
                foreach ($modules as $key => $value) {
                    $data_permissions = array();
                    $data_permissions['module'] = $value;
                    $data_permissions['user_id'] = $inserted;
                    $to_insert = array_merge($data_permissions, $permissions);
    
                    $db->table('users_permissions')->insert($to_insert);
                }

                $response['status'] = true;
                $response['uniqid'] = $uniqid;
            } else {
                $response['status'] = false;
                $response['code'] = 'Ocurrio un error al registrar al usuario. Por favor vuelvelo a intentar';
            }

            return $response;
        }

        public function update($input): array
        {
            $response = array();
            $data = [
                'fullname' => $input['fullname'],
                'email' => (new aCore)->encrypt_decrypt($input['email'], 'encrypt'),
                'type' => $input['type'],
            ];

            if(array_key_exists('state', $input)) {
                $data['state'] = 1;
            } else {
                $data['state'] = 0;
            }

            if(strlen($input['password']) > 0) {
                $data['password'] = (new aCore)->crypt_password($input['password']);
            }
            
            (new mUser)->update($data, 'uniqid', $input['uniqid']);

            $response['status'] = true;
            return $response;
        }

        public function permissions($uniqid) {
            $user = (new mUser)->get('uniqid', $uniqid);
            return (new mUser)->permissions($user->id);
        }

        public function update_permissions($input, $user_id, $permission_id): array
        {
            $response = array();
            $data = [
                'can_view' => $input['p_can_view'],
                'can_add' => $input['p_can_add'],
                'can_edit' => $input['p_can_edit'],
                'can_delete' => $input['p_can_delete'],
                'can_auth' => $input['p_can_auth']
            ];

            (new mUser)->update_permissions($data, $user_id, $permission_id);

            $response['status'] = true;
            return $response;
        }

    }