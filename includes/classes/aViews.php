<?php 

    class aViews {

        public function make($view, $title, $values = null) {
            global $settings, $user;
            $v = time();

            eval("\$headerinclude =\"" . self::get("headerinclude"). "\";");
            eval("\$menu    =\"" . self::get("menu"). "\";");
            eval("\$header  =\"" . self::get("header"). "\";");
            eval("\$content =\"" . self::get("content-" . $view, false). "\";");
            eval("\$footer  =\"" . self::get("footer"). "\";");
            eval("\$global  =\"" . self::get("global"). "\";");
            echo $global;
        }

        private function get($view, $partial = true, $static = false) {
            if($partial) {
                $template = ROOT . "/views/partials/$view.tpl";
            } else {
                if($static) {
                    $template = ROOT . "/views/static/$view.tpl";
                } else {
                    $template =  ROOT . "/views/$view.tpl";
                }
            }

            if(!file_exists($template)) {
                die("No existe la plantilla especificada: [$template]");
            } else {
                $content = file_get_contents($template);
                $content = str_replace("\\'", "'", addslashes($content));
                return $content;
            }
        }

        public function static($view, $values = null) {
            global $app;

            eval("\$global =\"" . self::get($view, false, true) . "\";");
            echo $global;
        }

        public function login() {
            global $settings;
            $v = time();

            eval("\$global =\"" .self::get("login", false). "\";");
            echo $global;
        }

    }