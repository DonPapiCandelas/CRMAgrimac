<?php

    class cPlagas {

        public function list() {
            return (new mPlagas)->get();
        }

        public function find($plaga_id) {
            return (new mPlagas)->get('id', $plaga_id);
        }

        public function add($data): array
        {
            global $db;
            $response = array();

            $inserted = $db->table('plagas')->insert($data);

            if($inserted > 0) {
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['code'] = 'Ocurrio un error al registrar la plaga. Por favor vuelvelo a intentar';
            }

            return $response;
        }

    }