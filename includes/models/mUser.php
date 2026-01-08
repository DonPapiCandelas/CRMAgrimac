<?php

    class mUser {

        public function get($column = null, $value = null, $specific = false) {
            global $db;

            if($column != null  && $value != null) {
                $result = $db->table('users')->where($column, $value)->get();
            } else {
                if($specific === true) {
                    $result = $db->select('username, fullname, email, type, register, lastlogin, lastactivity, state, uniqid')->table('users')->where('id', '>', 1)->getAll();
                } else {
                    $result = $db->table('users')->getAll();
                }
            }

            return $result;
        }

        public function update($data, $column, $value) {
            global $db;

            $db->table('users')->where($column, $value)->update($data);
        }

        public function permissions($user_id) {
            global $db;

            return $db->table('users_permissions')->where(['user_id' => $user_id])->getAll();
        }

        public function update_permissions($data, $user_id, $permission_id) {
            global $db;

            $db->table('users_permissions')->where(['user_id' => $user_id, 'id' => $permission_id])->update($data);
        }

    }