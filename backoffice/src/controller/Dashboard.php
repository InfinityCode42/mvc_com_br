<?php
namespace backoffice\src\controller;

use backoffice\src\controller\core\Core;

class Dashboard
{
    private $core;
    private $view;

    public function __construct()
    {
        $this->core = new Core;
        $this->core->verificaLogin();
        $this->core->verModulos();
    }
    public function index()
    {
        MontagemView::view("/dashboard/dashboard");
    }
    public function destroy(){
        session_destroy();
        $this->core->return('success', 'Sucesso', 'Você será redirecionado para a tela de login!!');
    }
}
?>
