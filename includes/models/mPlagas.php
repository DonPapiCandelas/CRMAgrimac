<?php

    class mPlagas {

        public function get($column = null, $value = null, $specific = false) {
            global $db;

            if($column != null  && $value != null) {
                $result = $db->table('plagas')->where($column, $value)->get();
            } else {
                $result = $db->table('plagas')->getAll();
            }

            return $result;
        }

        public function update($data, $column, $value) {
            global $db;

            $db->table('plagas')->where($column, $value)->update($data);
        }

    }