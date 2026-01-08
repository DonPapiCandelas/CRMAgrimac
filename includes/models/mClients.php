<?php

    class mClients {

        public function get($column = null, $value = null) {
            global $sql;

            if($column != null  && $value != null) {
                $result = $sql->table('vwLBSCustomerList')->where($column, $value)->get();
            } else {
                $result = $sql->select('UPPER(BusinessEntity) AS Empresa, Currency, CreditLimit, ReceptorUsoCFDI, MetodoPago, FormaPago')->table('vwLBSCustomerList')->where('Deleted', '0')->getAll();
            }

            return $result;
        }

    }