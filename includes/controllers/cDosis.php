<?php

    class cDosis {

        public function list(): array
        {
            $cultivos = (new mDosis)->get();
            $datos = null;

            foreach ($cultivos as $cultivo) {
                $producto = (new cProducts)->find($cultivo->product_id);
                $plaga = (new cPlagas)->find($cultivo->plaga_id);
                $cultivoSearch = (new cCultivos)->find($cultivo->cultivo_id);
                $cultivo->cultivo = $cultivoSearch->cultivo;
                $cultivo->plaga = $plaga->plaga;
                $cultivo->producto = $producto['ProductName'];
                $datos[] = $cultivo;
            }

            return $datos;
        }

        public function add($inputData): array
        {
            global $db;
            $response = array();
            
            $data['product_id'] = $inputData['producto'];
            $data['cultivo_id'] = $inputData['cultivo'];
            $data['plaga_id'] = $inputData['plaga'];
            $data['intervalo'] = $inputData['intervalo'];
            $data['dosis_min'] = $inputData['dosis_min'];
            $data['dosis_max'] = $inputData['dosis_max'];
            $data['dosis_recomendada'] = $inputData['dosis_recomendada'];
            $data['usa_mex'] = $inputData['usa_mex'];
            $inserted = $db->table('dosis_plagas')->insert($data);

            if($inserted > 0) {
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['code'] = 'Ocurrio un error al registrar el cultivo. Por favor vuelvelo a intentar';
            }

            return $response;
        }

        public function update($data): array
        {
            $id = $data['control_id'];
            unset($data['control_id']);

            $data['product_id'] = $data['producto'];
            unset($data['producto']);
            $data['cultivo_id'] = $data['cultivo'];
            unset($data['cultivo']);
            $data['plaga_id'] = $data['plaga'];
            unset($data['plaga']);
            
            (new mDosis)->update($data, 'id', $id);
            $response['status'] = true;
            return $response;
        }

    }