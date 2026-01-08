<?php

    class route {

        private $expr;
        private $callback;
        private $matches;
        private $methods = array('GET', 'POST', 'HEAD', 'PUT', 'DELETE');

        public function __construct($expr, $callback, $methods = null) {
            $this->expr = '#^' . $expr . '/?$#';
            $this->callback = $callback;

            if($methods !== null) {
                $this->methods = is_array($methods) ? $methods : array($methods);
            }
        }

        public function matches($path) {
            if(preg_match($this->expr, $path, $this->matches) && in_array($_SERVER['REQUEST_METHOD'], $this->methods)) {
                return true;
            }

            return false;
        }

        public function exec() {
            return call_user_func_array($this->callback, array_slice($this->matches, 1));
        }

    }