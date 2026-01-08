<?php

    class MyPDO extends PDO {

        function query($query, $values=null) {
            if($query == "")
                return false;

            if($sth = $this->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL))) {
                $res = ($values) ? $sth->execute($values) : $sth->execute();
                if(!$res)
                    return false;
            }           
            return $sth;
        }

    }