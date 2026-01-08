<?php

    class mCenters {

        public function get($column = null, $value = null) {
            global $sql;

            if($column != null  && $value != null) {
                $result = $sql->table('vwLBSCostCenterList')->where($column, $value)->get();
            } else {
                $result = $sql->select('CostCenterID, CostCenterName')->table('vwLBSCostCenterList')->where('Deleted', '0')->getAll();
            }

            return $result;
        }

    }