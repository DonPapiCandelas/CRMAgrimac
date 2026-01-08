<?php

    class mServices {

        public function get($column = null, $value = null) {
            global $sql;

            if($column != null  && $value != null) {
                $result = $sql->table('vwLBSServiceList')->where($column, $value)->get();
            } else {
                $result = $sql->select('ProductKey AS ProductCode, ProductName, Category1 AS Category, Unit, Currency, PriceList AS Price, CostPrice AS Cost, TaxTypeName AS Tax')->table('vwLBSServiceList')->getAll();
            }

            return $result;
        }

    }