<?php 
namespace backoffice\src\core\utils;

class utils {
    private static function getContentView($view){
        $file = __DIR__.'/backoffice/src/public/includes/' .$view.'.php';

        if(file_exists($file) === TRUE){
            return file_get_contents($file);
        }else{
            return $file = '';
        }

    }
    public static function render($view, $vars = []){
        $conteudoView = self::getContentView($view);

        $chaves = array_keys($vars);
        $chaves = array_map(function ($item){
            return '[#'.$item.'#]';
        }, $chaves);


        return str_replace($chaves, array_values($vars), $conteudoView);
    }
}
?>