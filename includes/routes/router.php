<?php

    class router {

        public $base_path;
        private $path;
        public array $routes = array();

        public function __construct($base_path = '') {
            $this->base_path = $base_path;
            $path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            $path = substr($path, strlen($base_path));
            $this->path = $path;
        }

        public function all($expr, $callback, $methods = null) {
            $this->routes[] = new route($expr, $callback, $methods);
        }

        public function add($expr, $callback, $methods = null) {
            $this->all($expr, $callback, $methods);
        }

        public function get($expr, $callback) {
            $this->routes[] = new route($expr, $callback, 'GET');
        }

        public function post($expr, $callback) {
            $this->routes[] = new route($expr, $callback, 'POST');
        }

        public function head($expr, $callback) {
            $this->routes[] = new route($expr, $callback, 'HEAD');
        }

        public function put($expr, $callback) {
            $this->routes[] = new route($expr, $callback, 'PUT');
        }

        public function delete($expr, $callback) {
            $this->routes[] = new route($expr, $callback, 'DELETE');
        }

        /**
         * @throws routeNotFoundException
         */
        public function route() {
            foreach($this->routes as $route) {
                if($route->matches($this->path)) {
                    return $route->exec();
                }
            }

            throw new routeNotFoundException("No routes matching $this->path");
        }

        public function url($path = null): string
        {
            if($path === null) {
                $path = $this->path;
            }

            return $this->base_path . $path;
        }

        public function path($path = null) {
            if($path === null) {
                $path = $this->path;
            }

            return $path;
        }

        public function redirect($from, $to, $code = 302) {
            $this->all($from, function() use($to, $code) {
                http_response_code($code);
                header("Location: " . $this->base_path . $to);
            });
        }

    }