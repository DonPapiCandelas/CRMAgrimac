<?php

    class mProducts {

        public function get($column = null, $value = null) {
            global $sql;

            if($column != null  && $value != null) {
                $result = $sql
                    ->select('e.*, e.[FECHA DE CADUCIDAD] AS CADUCIDAD, p.*')
                    ->table('vwLBSProductList AS p')
                    ->leftJoin('orgProductExt AS e', 'p.ProductID', 'e.IDExtra')
                    ->where($column, $value)
                    ->get();
            } else {
                $result = $sql
                    ->select('e.*, ProductID, ProductKey AS ProductCode, ProductName, Category1 AS Category, Unit, Currency, PriceList AS Price, CostPrice AS Cost, TaxTypeName AS Tax')
                    ->table('vwLBSProductList AS p')
                    ->leftJoin('orgProductExt AS e', 'p.ProductID', 'e.IDExtra')
                    ->getAll();
            }

            return $result;
        }

    }