<?php

    class mRequisitions {

        public function createDocument($data) {
            global $db;

            $db->table('requisitions_attach')->insert($data);
        }

        public function get($column = null, $value = null) {
            global $db;

            if($column != null  && $value != null) {
                $result = $db->table('requisitions')->where($column, $value)->getAll();
            } else {
                $result = $db->select('r.*')->table('requisitions as r')->getAll();
            }

            return $result;
        }

        public function in($campo, $in = array()) {
            global $db;

            $result = array();

            if(count($in) > 0) {
                $result = $db->table('requisitions')->where(['cancelled' => 0])->in($campo, $in)->getAll();
            }

            return $result;
        }

        public function getProducts($uniqid) {
            global $db;

            return $db->select('p.*')->table('requisitions_detail as p')->where('requisition_id', $uniqid)->getAll();
        }

        public function getDocument($uniqid) {
            global $db;

            return $db->select('d.*')->table('requisitions_attach as d')->where('uniqid', $uniqid)->get();
        }

        public function getDocuments($uniqid) {
            global $db;

            return $db->select('d.*')->table('requisitions_attach as d')->where('requisition_id', $uniqid)->orderBy('id desc')->getAll();
        }

        public function getNotes($uniqid) {
            global $db;

            return $db->select('n.*')->table('requisitions_notes as n')->where('requisition_id', $uniqid)->orderBy('id desc')->getAll();
        }

        public function delete_document($uniqid) {
            global $db;

            $db->table('requisitions_attach')->where('uniqid', $uniqid)->delete();
        }

        public function delete_documents($uniqid) {
            global $db;

            $db->table('requisitions_attach')->where('requisition_id', $uniqid)->delete();
        }

        public function delete_note($uniqid) {
            global $db;

            $db->table('requisitions_notes')->where('uniqid', $uniqid)->delete();
        }

        public function delete_notes($uniqid) {
            global $db;

            $db->table('requisitions_notes')->where('requisition_id', $uniqid)->delete();
        }

        public function delete_rows($uniqid) {
            global $db;

            $db->table('requisitions_detail')->where('requisition_id', $uniqid)->delete();
        }

        public function delete($uniqid) {
            global $db;

            $db->table('requisitions')->where('uniqid', $uniqid)->delete();
        }

        public function update($data, $column, $value) {
            global $db;

            $db->table('requisitions')->where($column, $value)->update($data);
        }

        public function updateRow($data, $column, $value) {
            global $db;

            $db->table('requisitions_detail')->where($column, $value)->update($data);
        }

        public function numRows(): int
        {
            global $db;

            return $db->numRows();
        }

    }