<?php 
function load(string $controller, string $action)
{
    try {
        // se controller existe
        $controllerNamespace = "backoffice\\src\\controller\\{$controller}";
        var_dump(class_exists($controllerNamespace));
        if (!class_exists($controllerNamespace)) {
            throw new Exception("O controller {$controller} não existe");
        }

        $controllerInstance = new $controllerNamespace();

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception(
                "O método {$action} não existe no controller {$controller}"
            );
        }

        $controllerInstance->$action((object) $_REQUEST);

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$router = [
  "GET" => [
    "/" => fn () => load("restrito", "index"),
    "/cadastrar" => fn () => load("restrito", "cadastrar"),
    "/dashboard" => fn () => load("dashboard", "index"),

    "/login" => fn () => load("restrito", "login"),

    "/usuarios" => fn () => load("usuarios", "index"),
    "/usuarios/cadastrar" => fn () => load("usuarios", "cadastrar"),
    "/usuarios/ver" => fn () => load("usuarios", "ver"),
    

    "/carros" => fn () => load("Carros", "index"),
    "/carros/cadastrar" => fn () => load("Carros", "cadastrar"),
    "/carros/ver" => fn () => load("Carros", "ver"),
    

    "/alugar" => fn () => load("Alugar", "index"),
    "/alugar/ver" => fn () => load("Alugar", "ver"),
  ],
  "POST" => [
    "/login" => fn () => load("restrito", "login"),
    "/restrito/salvar" => fn () => load("restrito", "salvar"),

    "/usuarios/salvar" => fn () => load("usuarios", "salvar"),
    "/usuarios/alterar" => fn () => load("usuarios", "alterar"),
    "/usuarios/remover" => fn () => load("usuarios", "remover"),
    
    "/carros/salvar" => fn () => load("Carros", "salvar"),
    "/carros/alterar" => fn () => load("Carros", "alterar"),
    "/carros/remover" => fn () => load("Carros", "remover"),

    "/alugar/alterar" => fn () => load("Alugar", "alugar"),

    

  ],
  "DELETE" => [
    "/dashboard/destroy" => fn () => load("dashboard", "destroy"),
  ],

];
