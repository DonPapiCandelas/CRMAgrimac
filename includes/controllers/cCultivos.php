<?php

    class cCultivos {

        public function list() {
            return (new mCultivos)->get();
        }

        public function find($cultivo_id) {
            return (new mCultivos)->get('id', $cultivo_id);
        }

        public function add($data): array
        {
            global $db;
            $response = array();

            $inserted = $db->table('cultivos')->insert($data);

            if($inserted > 0) {
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['code'] = 'Ocurrio un error al registrar el cultivo. Por favor vuelvelo a intentar';
            }

            return $response;
        }

    }