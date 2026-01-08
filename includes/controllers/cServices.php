<?php

    class cServices {

        public function list() {
            return (new mServices)->get();
        }

    }