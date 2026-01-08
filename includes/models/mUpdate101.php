<?php

    class mUpdate101 {

        public function Inicializar() {
            // Creacion / Actualizacion de Tablas
            self::InsertarTablas();
            self::ActualizarTablas();
            // Modificacion de Permisos
            self::InsertarPermisos();
            // Modificaciones Generales
            self::UpdateVersion();
        }

        public function InsertarTablas() {
            global $db;

            $db->query("SHOW TABLES FROM agrimac LIKE 'amac_insumos'")->fetchAll();
            if($db->numRows() == 0) {
                $db->query("CREATE TABLE amac_insumos (
                    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    date bigint(30) NOT NULL DEFAULT 0,
                    user_id varchar(40) NOT NULL DEFAULT 0,
                    cancelled tinyint(1) NOT NULL DEFAULT 0,
                    cancelled_by varchar(40) NOT NULL DEFAULT 0,
                    cancelled_date bigint(30) NOT NULL DEFAULT 0,
                    cancelled_text text DEFAULT NULL,
                    authorized_by varchar(40) NOT NULL DEFAULT 0,
                    authorized_date bigint(30) NOT NULL DEFAULT 0,
                    observations text DEFAULT NULL,
                    state int(2) NOT NULL DEFAULT 0,
                    exported tinyint(1) NOT NULL DEFAULT 0,
                    uniqid varchar(40) NOT NULL DEFAULT 0
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8")->exec();
            }

            $db->query("SHOW TABLES FROM agrimac LIKE 'amac_insumos_detail'")->fetchAll();
            if($db->numRows() == 0) {
                $db->query("CREATE TABLE amac_insumos_detail (
                    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    insumo_id varchar(40) NOT NULL DEFAULT 0,
                    product_id int(11) NOT NULL DEFAULT 0,
                    quantity int(11) NOT NULL DEFAULT 0,
                    unit varchar(15) NOT NULL,
                    cost_center int(11) NOT NULL DEFAULT 0,
                    depot_id int(11) NOT NULL DEFAULT 0,
                    lote varchar(255) DEFAULT NULL,
                    caducidad varchar(15) DEFAULT NULL,
                    observations text DEFAULT NULL,
                    authorized tinyint(1) NOT NULL DEFAULT 0,
                    authorized_by varchar(40) NOT NULL DEFAULT 0,
                    authorized_date bigint(30) NOT NULL DEFAULT 0,
                    uniqid varchar(40) NOT NULL DEFAULT 0
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8")->exec();
            }

            $db->query("SHOW TABLES FROM agrimac LIKE 'amac_insumos_notes'")->fetchAll();
            if($db->numRows() == 0) {
                $db->query("CREATE TABLE amac_insumos_notes (
                    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    insumo_id varchar(40) NOT NULL DEFAULT 0,
                    date bigint(30) NOT NULL DEFAULT 0,
                    note text DEFAULT NULL,
                    user_id varchar(40) NOT NULL DEFAULT 0,
                    uniqid varchar(40) NOT NULL DEFAULT 0
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8")->exec();
            }
        }

        public function ActualizarTablas() {
            global $db;
            //
            $db->query("SHOW COLUMNS FROM amac_users_permissions LIKE 'can_auth'")->fetchAll();
            if($db->numRows() == 0) {
                $db->query("ALTER TABLE amac_users_permissions ADD can_auth BOOLEAN NOT NULL DEFAULT FALSE AFTER can_delete")->exec();
            }
            //
            $db->query("SHOW COLUMNS FROM amac_insumos_detail LIKE 'plaga'")->fetchAll();
            if($db->numRows() == 0) {
                $alter = $db->query("ALTER TABLE amac_insumos_detail ADD plaga VARCHAR(255) NULL DEFAULT NULL AFTER caducidad")->exec();
            }
            //
            $db->query("SHOW COLUMNS FROM amac_insumos_detail LIKE 'dosis_hectarea'")->fetchAll();
            if($db->numRows() == 0) {
                $alter = $db->query("ALTER TABLE amac_insumos_detail ADD dosis_hectarea VARCHAR(255) NULL DEFAULT NULL AFTER plaga")->exec();
            }
            //
            $db->query("SHOW COLUMNS FROM amac_insumos_detail LIKE 'dosis_tambo'")->fetchAll();
            if($db->numRows() == 0) {
                $alter = $db->query("ALTER TABLE amac_insumos_detail ADD dosis_tambo VARCHAR(255) NULL DEFAULT NULL AFTER dosis_hectarea")->exec();
            }
            //
            $db->query("SHOW COLUMNS FROM amac_insumos_detail LIKE 'ph'")->fetchAll();
            if($db->numRows() == 0) {
                $alter = $db->query("ALTER TABLE amac_insumos_detail ADD ph VARCHAR(255) NULL DEFAULT NULL AFTER dosis_tambo")->exec();
            }
            //
            $db->query("SHOW COLUMNS FROM amac_insumos_detail LIKE 'valvula'")->fetchAll();
            if($db->numRows() == 0) {
                $alter = $db->query("ALTER TABLE amac_insumos_detail ADD valvula VARCHAR(255) NULL DEFAULT NULL AFTER ph")->exec();
            }
            //
            $db->query("SHOW COLUMNS FROM amac_insumos_detail LIKE 'drenaje'")->fetchAll();
            if($db->numRows() == 0) {
                $alter = $db->query("ALTER TABLE amac_insumos_detail ADD drenaje VARCHAR(255) NULL DEFAULT NULL AFTER valvula")->exec();
            }
            //
            $db->query("SHOW COLUMNS FROM amac_insumos_detail LIKE 'conductividad'")->fetchAll();
            if($db->numRows() == 0) {
                $alter = $db->query("ALTER TABLE amac_insumos_detail ADD conductividad VARCHAR(255) NULL DEFAULT NULL AFTER drenaje")->exec();
            }
        }
    
        public function InsertarPermisos() {
            global $db;

            $usuarios = $db->table('users')->getAll();
            foreach ($usuarios as $usuario) {
                // Permiso Almacenes
                $db->table('users_permissions')->where(['user_id' => $usuario->id, 'module' => 'warehouses'])->getAll();
                if($db->numRows() == 0) {
                    $data = [
                        'user_id' => $usuario->id,
                        'module' => 'warehouses',
                        'can_view' => 1,
                        'can_add' => 0,
                        'can_edit' => 0,
                        'can_delete' => 0,
                        'can_auth' => 0,
                    ];
                    $db->table('users_permissions')->insert($data);
                }
                // Permiso insumos
                $db->table('users_permissions')->where(['user_id' => $usuario->id, 'module' => 'insumos'])->getAll();
                if($db->numRows() == 0) {
                    $data = [
                        'user_id' => $usuario->id,
                        'module' => 'insumos',
                        'can_view' => 1,
                        'can_add' => 0,
                        'can_edit' => 0,
                        'can_delete' => 0,
                        'can_auth' => 0,
                    ];
                    $db->table('users_permissions')->insert($data);
                }
            }
        }

        public function UpdateVersion() {
            global $db;
            $alter = $db->query("UPDATE amac_settings SET value='beta 1.2 release-20210102-02' WHERE name='version'")->exec();
        }

    }