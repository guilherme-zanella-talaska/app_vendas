<?php

namespace Util;

class RotasUtil{
 
    public static function getRotas(){
        $urls = self::getUrls();
        $request = [];
        $request['rota']    = strtoupper($urls[2]);
        $request['recurso'] = $urls[3] ? $urls[3] : null;
        $request['id']      = $urls[4] ? $urls[4] : null;
        $request['metodo']  = $_SERVER['REQUEST_METHOD'];

        return $request;
    }

    public static function getUrls(){

        $uri_request = $_SERVER['REQUEST_URI'];
        $uri = str_replace('/' . DIR_PROJETO, '', $uri_request);
        return explode('/', trim($uri, '/'));

    }
        

}



?>