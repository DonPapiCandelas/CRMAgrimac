<?php

    class aCore {

        public function loadAll() {
            $protected = array("_GET", "_POST", "_SERVER", "_COOKIE", "_FILES", "_ENV", "GLOBALS");
            
            foreach($protected as $var) {
                if(isset($_POST[$var]) || isset($_GET[$var]) || isset($_COOKIE[$var]) || isset($_FILES[$var])) {
                    die("Hacking attempt");
                }
            }

            $input = self::parse_incoming($_GET);
            $input = self::parse_incoming($_POST);
            
            return $input;
        }

        private function parse_incoming($array) {
            $input = array();

            if(!is_array($array)) {
                return;
            }

            foreach ($array as $key => $value) {
                $input[$key] = $value;
            }

            return $input;
        }

        public function get_settings(): array
        {
            global $db;

            $settings = array();
            $result = $db->table('settings')->getAll();

            foreach($result as $row) {
                $settings[$row->name] = $row->value;
            }

            return $settings;
        }

        public function get_cookies() {
            global $settings, $cookies;

            if(!is_array($_COOKIE)) {
                return;
            }

            $prefix_length = strlen($settings['cookie_prefix']);

            foreach($_COOKIE as $key => $value) {
                if($prefix_length && substr($key, 0, $prefix_length) == $settings['cookie_prefix']) {
                    $key = substr($key, $prefix_length);

                    if(is_array($cookies) && array_key_exists($key, $cookies)) {
                        unset($cookies[$key]);
                    }
                }

                if(empty($cookies[$key])) {
                    $cookies[$key] = $value;
                }
            }
            
            self::unset_globals($_COOKIE);
            return $cookies;
        }

        public function my_set_cookie($name, $value, $expires = 0, $httpOnly = true) {
            global $settings, $cookies;

            if(!$settings['cookie_path']) {
                $settings['cookie_path'] = '/';
            }

            if($expires != 0) {
                $expires = time() + (int)$expires;
            } else {
                $expires = time() + (int)$settings['cookie_expire'];
            }

            $settings['cookie_path'] = str_replace(array("\n", "\r"), "", $settings['cookie_path']);
            $settings['cookie_domain'] = str_replace(array("\n", "\r"), "", $settings['cookie_domain']);
            $settings['cookie_prefix'] = str_replace(array("\n", "\r"), "", $settings['cookie_prefix']);

            $cookie = "Set-Cookie: {$settings['cookie_prefix']}$name=".urlencode($value);

            if($expires > 0) {
                $cookie .= "; expires=".@gmdate('D, d-M-Y H:i:s \\G\\M\\T', $expires);
            }

            if(!empty($settings['cookie_path'])) {
                $cookie .= "; path={$settings['cookie_path']}";
            }

            if(!empty($settings['cookie_domain'])) {
                if($settings['cookie_domain'] == 'localhost') {
                    $settings['cookie_domain'] = false;
                }
                $cookie .= "; domain={$settings['cookie_domain']}";
            }

            if($httpOnly) {
                $cookie .= "; HttpOnly";
            }
            
            $cookies[$name] = $value;
            header($cookie, false);
        }

        public function my_unset_cookie($name) { 
            global $cookies;

            $expires = -3600;
            self::my_set_cookie($name, "", $expires);

            unset($cookies[$name]);
        }

        public function unset_globals($array) {
            if(!is_array($array)) {
                return;
            }

            foreach(array_keys($array) as $key) {
                unset($GLOBALS[$key]);
            }
        }

        public function get_date() {
            global $settings;

            date_default_timezone_set($settings['timezone']);
            return date($settings['date_format']);
        }

        public function get_time() {
            global $settings;

            date_default_timezone_set($settings['timezone']);
            return date($settings['time_format']);
        }

        public function get_stampToDate($time = 0) {
            global $settings;

            date_default_timezone_set($settings['timezone']);
            return date($settings['date_format'] . ' ' . $settings['time_format'], $time);
        }

        public function update_settings($data) {
            global $settings;

            foreach($data as $key => $value) {
                self::set_setting($key, $value);
            }

        }

        private function set_setting($column, $value) {
            global $db;

            if(strlen($value) > 0) {
                $data = [
                    'value' => $value
                ];

                $db->table('settings')->where('name', $column)->update($data);
            }
        }

        public function new_guid(): string
        {
            return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                mt_rand( 0, 0xffff ),
                mt_rand( 0, 0x0fff ) | 0x4000,
                mt_rand( 0, 0x3fff ) | 0x8000,
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );
        }

        public function encrypt_decrypt($string, $action) {
            global $settings;
    
            $encrypt_method = "AES-256-CBC";
            $secret_key = $settings['encryptation_key'];
    
            $key = hash('sha256', $secret_key, true);
    
            if($action == 'encrypt') {
                $iv = openssl_random_pseudo_bytes(16);
                $cipherText = openssl_encrypt($string, $encrypt_method, $key, OPENSSL_RAW_DATA, $iv);
                $hash = hash_hmac('sha256', $cipherText, $key, true);
    
                return base64_encode($iv.$hash.$cipherText); 
            } else if($action == 'decrypt') {
                $string = base64_decode($string);
                $iv = substr($string, 0, 16);
                $hash = substr($string, 16, 32);
                $cipherText = substr($string, 48);
    
                if(hash_hmac('sha256', $cipherText, $key, true) !== $hash) return null;
                
                return openssl_decrypt($cipherText, $encrypt_method, $key, OPENSSL_RAW_DATA, $iv);
            }
    
        }

        public function crypt_password($password): ?string
        {
            $salt = "$2y$10$" . bin2hex(openssl_random_pseudo_bytes(11));
            return crypt($password, $salt);
        }
        
        public function round_number($number, $decimals): float
        {
            return round($number, $decimals);
        }
    
        public function money_format($number, $decimals): string
        {
            global $settings;    
            return $settings['currency_symbol'] . number_format($number, $decimals);
        }

        public function get_ip(): string
        {
            $ip = strtolower($_SERVER['REMOTE_ADDR']);

            $addresses = array();
            
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $addresses = explode(',', strtolower($_SERVER['HTTP_X_FORWARDED_FOR']));
            } else if(isset($_SERVER['HTTP_X_REAL_IP'])) {
                $addresses = explode(',', strtolower($_SERVER['HTTP_X_REAL_IP']));
            }

            if(is_array($addresses)) {
                foreach ($addresses as $val) {
                    $val = trim($val);
                    if(self::my_inet_ntop(self::my_inet_pton($val)) == $val && !preg_match("#^(10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.|192\.168\.|fe80:|fe[c-f][0-f]:|f[c-d][0-f]{2}:)#", $val)) {
					    $ip = $val;
					    break;
				    }
                }
            }

            if(!$ip) {
                if(isset($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = strtolower($_SERVER['HTTP_CLIENT_IP']);
                }
            }

            return $ip;
        }

        // Decrypt IP
        public function my_inet_pton($ip) {
            if(function_exists('inet_pton')) {
                return @inet_pton($ip);
            } else {
                $r = ip2long($ip);

                if($r !== false && $r != -1) {
                    return pack('N', $r);
                }

                $delim_count = substr_count($ip, ':');

                if($delim_count < 1 || $delim_count > 7) {
                    return false;
                }

                $r = explode(':', $ip);
                $rcount = count($r);

                if(($doub = array_search('', $r, 1)) !== false) {
                    $length = (!$doub || $doub == $rcount - 1 ? 2 : 1);
                    array_splice($r, $doub, $length, array_fill(0, 8 + $length - $rcount, 0));
                }

                $r = array_map('hexdec', $r);
                array_unshift($r, 'n*');
                return call_user_func_array('pack', $r);
            }
        }

        // Crypt IP
        public function my_inet_ntop($ip) {
            if(function_exists('inet_ntop')) {
                return @inet_ntop($ip);
            }
            else {
                switch (strlen($ip)) {
                    case 4:
                        list(, $r) = unpack('N', $ip);
                        return long2ip($r);
                    case 16:
                        $r = substr(chunk_split(bin2hex($ip), 4, ':'), 0, -1);
                        return preg_replace(
                            array('/(?::?\b0+\b:?){2,}/', '/\b0+([^0])/'),
					        array('::', '(int)"$1"?"$1":"0$1"'),
                            $r
                        );
                }

                return false;
            }
        }

        public static function getBinarySeed($bytes) {
            $output = null;

            if (version_compare(PHP_VERSION, '7.0', '>=')) {
                try {
                    $output = random_bytes($bytes);
                } catch(Exception $e) { }
            }

            if (strlen($output) < $bytes) {
                if (@is_readable('/dev/urandom') && ($handle = @fopen('/dev/urandom', 'rb'))) {
                    $output = @fread($handle, $bytes);
                    @fclose($handle);
                }
            } else {
                return $output;
            }
            if (strlen($output) < $bytes) {
                if (function_exists('openssl_random_pseudo_bytes')) {
                    if (DIRECTORY_SEPARATOR == '/' && version_compare(PHP_VERSION, '5.3.4', '>=')) {
                        $output = openssl_random_pseudo_bytes($bytes, $crypto_strong);
                        if (!$crypto_strong) {
                            $output = null;
                        }
                    } 
                }
            } else {
                return $output;
            }
            ///
            if(strlen($output) < $bytes) {
                if(class_exists('COM')) {
                    try {
                        $CAPI_Util = new COM('CAPICOM.Utilities.1');
                        if(is_callable(array($CAPI_Util, 'GetRandom'))) {
                            $output = $CAPI_Util->GetRandom($bytes, 0);
                        }
                    } catch (Exception $e) { }
                }
            } else {
                return $output;
            }

            if(strlen($output) < $bytes) {
                $unique_state = microtime().@getmypid();
                $rounds = ceil($bytes / 16);
                for($i = 0; $i < $rounds; $i++) {
                    $unique_state = md5(microtime().$unique_state);
                    $output .= md5($unique_state);
                }

                $output = substr($output, 0, ($bytes * 2));
                return pack('H*', $output);
            } else {
                return $output;
            }
        }

        public static function get_secure_seed() {
            $bytes = PHP_INT_SIZE;
            do {
                $output = self::getBinarySeed($bytes);
                $elements = unpack('N2', $output);
                $output = abs($elements[1] << 32 | $elements[2]);
            }
            while ($output > PHP_INT_MAX);
            return $output;
        }

        public function my_rand($min = 0, $max = PHP_INT_MAX) {
            if($min === null || $max === null || $max < $min) {
                $min = 0;
                $max = PHP_INT_MAX;
            }

            if (version_compare(PHP_VERSION, '7.0', '>=')) {
                try {
                    $result = random_int($min, $max);
                } catch (Exception $e) { }

                return $result;
            }

            $seed = self::get_secure_seed();
            $distance = $max - $min;
            return $min + floor($distance * ($seed / PHP_INT_MAX));
        }

        public function random_key($length = 8, $complex = false): string
        {
            $setting = array_merge(range(0, 9), range('A', 'Z'), range('a', 'z'));
            $string = array();

            if($complex) {
                $string[] = $setting[self::my_rand(0, 9)];
                $string[] = $setting[self::my_rand(10, 35)];
                $string[] = $setting[self::my_rand(36, 61)];

                $length -= 3;
            }

            for($i = 0; $i < $length; $i++) {
                $string[] = $setting[self::my_rand(0, 61)];
            }

            shuffle($string);
            return implode($string);
        }

    }