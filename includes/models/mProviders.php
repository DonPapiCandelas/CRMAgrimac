<?php

    class mProviders {

        public function get($column = null, $value = null) {
            global $sql;

            if($column != null  && $value != null) {
                $result = $sql->table('vwLBSSupplierList')->where($column, $value)->get();
            } else {
                $result = $sql->select('BusinessEntityID, OfficialNumber AS RFC, UPPER(BusinessEntity) AS Empresa, Currency, CreditLimit, TaxTypeName AS Tax')->table('vwLBSSupplierList')->getAll();
            }

            return $result;
        }

    }