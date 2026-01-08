<?php

    class cCenters {

        public function list() {
            return (new mCenters)->get();
        }

        public function find($centerID) {
            return (new mCenters)->get('CostCenterID', $centerID);
        }

    }