<?php

    class mWarehouses {

        public function get($column = null, $value = null) {
            global $sql;

            if($column != null  && $value != null) {
                $result = $sql->table('vwLBSDepotList')->where($column, $value)->get();
            } else {
                $result = $sql->select('DepotID, DepotName')->table('vwLBSDepotList')->where('Deleted', '0')->getAll();
            }

            return $result;
        }

        public function stock($product = null, $depot = null) {
            global $sql;

            if($product != null  && $depot != null) {
                //$result = $sql->table('vwLBSProductQuantityList')->where(['ProductID' => $product, 'DepotID' => $depot])->get();
                $result = $sql->table('vwLBSProductQuantityList')->where(['ProductID' => $product, 'DepotID' => $depot])->get();
                
            } else {
                $result = $sql->table('vwLBSProductQuantityList')->getAll();
            }

            return $result;
        }

        public function inocuidad($producto, $inicio, $fin) {
            global $sql;

            $result = $sql->table('vwCSTControl')->where('ProductID', $producto)->between('DateTransaction', $inicio, $fin)->orderBy('DateTransaction')->getAll();

            return $result;
        }

    }