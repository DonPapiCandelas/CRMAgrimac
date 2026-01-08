<?php

    class cWarehouses {

        public function list() {
            return (new mWarehouses)->get();
        }

        public function find($depotID) {
            return (new mWarehouses)->get('DepotID', $depotID);
        }

        public function inocuidad(): array
        {
            $result = (new mWarehouses)->inocuidad($_POST['Producto'], $_POST['FechaInicio'], $_POST['FechaFin']);
            $movimientos = array();
            $saldo = 0;

            foreach($result as $row) {
                $saldo = $saldo + $row['Quantity'];
                $row['Entrada'] = ($row['Quantity'] < 0) ? 0 : $row['Quantity'];
                $row['Salida'] = ($row['Quantity'] < 0) ? $row['QuantityDoc']: 0;
                $row['Saldo'] = $saldo;
                $movimientos[] = $row;
            }

            return $movimientos;
        }

    }