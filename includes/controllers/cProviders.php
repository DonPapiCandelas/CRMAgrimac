<?php

    class cProviders {

        public function list() {
            return (new mProviders)->get();
        }

        public function find($provider_id) {
            return (new mProviders)->get('BusinessEntityID', $provider_id);
        }

    }