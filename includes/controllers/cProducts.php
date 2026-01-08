<?php

    class cProducts {

        public function list() {
            return (new mProducts)->get();
        }

        public function find($product_id) {
            return (new mProducts)->get('ProductID', $product_id);
        }

    }