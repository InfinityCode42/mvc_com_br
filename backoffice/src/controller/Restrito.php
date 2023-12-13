<?php
namespace backoffice\src\controller;

use Firebase\JWT\JWT;
use backoffice\src\controller\core\Core;

class Restrito
{
    private $core;
    private $view;
    private $utils;

    public function __construct()
    {
        $this->core = new Core;
    }
    public function index()
    {

        MontagemView::view("/restrito/login");
    }
    public function login()
    {
        if (isset($_POST['email']) && isset($_POST['senha'])) {

            $verificar['email'] = $_POST['email'];
            $verificar['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            if (!empty($verificar)) {

                $colunas = 'id, email, cpf, uf, tel,senha, idade, endereco, nome, tipo_usuario, modulos';
                $usuario = $this->core->getData('usuarios', $colunas, ['email' => $verificar['email']]);

                if (empty($usuario)) {
                    $this->core->return('error', 'Erro', 'Email ou senha incorretos!!', '', 1008);
                } else {
                    if (password_verify($_POST['senha'], $usuario[0]['senha'])) {

                        session_start();
                        $_SESSION['usuario_id'] = $usuario[0]['id'];
                        $_SESSION['email'] = $usuario[0]['email'];
                        $_SESSION['nome'] = $usuario[0]['nome'];
                        $_SESSION['uf'] = $usuario[0]['uf'];
                        $_SESSION['tel'] = $usuario[0]['tel'];
                        $_SESSION['idade'] = $usuario[0]['idade'];
                        $_SESSION['tipo_usuario'] = $usuario[0]['tipo_usuario'];
                        $_SESSION['endereco'] = $usuario[0]['endereco'];
                        $_SESSION['cpf'] = $usuario[0]['cpf'];


                        $res = $this->core->gerarToken($_SESSION['usuario_id'], $usuario[0], $_SERVER['REMOTE_ADDR']);
                        if ($res == 1) {
                            $this->core->return('success', 'Sucesso', 'Login realizado com sucesso!!', '', 200);
                        }
                    } else {
                        $this->core->return('error', 'Erro', 'Email ou senha incorretos!!', '', 1008);
                    }
                }

            }
        }
    }

    
}
