<?php

    class mInsumos {

        public function get($where = array()) {
            global $db;

            if(count($where) > 0) {
                $result = $db->table('insumos')->where($where)->getAll();
            } else {
                $result = $db->select('r.*')->table('insumos as r')->getAll();
            }

            return $result;
        }

        public function in($campo, $in = array()) {
            global $db;

            $result = array();

            if(count($in) > 0) {
                $result = $db->table('insumos')->where(['cancelled' => 0])->in($campo, $in)->getAll();
            }

            return $result;
        }

        public function getProducts($uniqid) {
            global $db;

            return $db->select('p.*')->table('insumos_detail as p')->where('insumo_id', $uniqid)->getAll();
        }


        public function getNotes($uniqid) {
            global $db;

            return $db->select('n.*')->table('insumos_notes as n')->where('insumo_id', $uniqid)->orderBy('id desc')->getAll();
        }

        public function delete_note($uniqid) {
            global $db;

            $db->table('insumos_notes')->where('uniqid', $uniqid)->delete();
        }

        public function delete_notes($uniqid) {
            global $db;

            $db->table('insumos_notes')->where('insumo_id', $uniqid)->delete();
        }

        public function delete_rows($uniqid) {
            global $db;

            $db->table('insumos_detail')->where('insumo_id', $uniqid)->delete();
        }

        public function delete($uniqid) {
            global $db;

            $db->table('insumos')->where('uniqid', $uniqid)->delete();
        }

        public function update($data, $column, $value) {
            global $db;

            $db->table('insumos')->where($column, $value)->update($data);
        }

        public function updateRow($data, $column, $value) {
            global $db;

            $db->table('insumos_detail')->where($column, $value)->update($data);
        }

        public function numRows(): int
        {
            global $db;

            return $db->numRows();
        }

    }