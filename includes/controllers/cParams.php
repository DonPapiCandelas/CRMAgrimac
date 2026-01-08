<?php

    class cParams {

        public function update($input): array
        {
            $response = array();

            foreach ($input as $key => $value) {
                $data = [
                    'value' => $value
                ];

                (new mParams)->update($data, 'name', $key);
            }

            $response['status'] = true;
            return $response;
        }

    }