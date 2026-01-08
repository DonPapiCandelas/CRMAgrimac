<?php

    class cClients {

        public function list() {
            return (new mClients)->get();
        }

    }