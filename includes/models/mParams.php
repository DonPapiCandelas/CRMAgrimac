<?php

    class mParams {

        public function update($data, $column, $value) {
            global $db;

            $db->table('settings')->where($column, $value)->update($data);
        }

    }