<?php

    class mCultivos {

        public function get($column = null, $value = null, $specific = false) {
            global $db;

            if($column != null  && $value != null) {
                $result = $db->table('cultivos')->where($column, $value)->get();
            } else {
                $result = $db->table('cultivos')->getAll();
            }

            return $result;
        }

        public function update($data, $column, $value) {
            global $db;

            $db->table('cultivos')->where($column, $value)->update($data);
        }

    }