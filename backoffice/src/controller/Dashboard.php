<?php
namespace backoffice\src\controller;

use backoffice\src\core\core;

class dashboard
{
    private $core;
    private $view;

    public function __construct()
    {
        $this->core = new core;

       session_start();
       if (empty($_SESSION)) {
           session_destroy();
           $this->core->redirect('/');
        }
    }
    public function index()
    {
        montagemview::view("/dashboard/dashboard");
    }
    public function destroy(){
        session_destroy();
        $this->core->return('success', 'Sucesso', 'Você será redirecionado para a tela de login!!');
    }
}
?>
