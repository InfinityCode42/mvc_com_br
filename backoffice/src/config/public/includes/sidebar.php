<aside
  class="sidenav shadow-card-padrao bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
  id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
      aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="/dashboard">
      <img src="backoffice\src\config\public\assets\img\illustrations\icon-documentation.svg"
        class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold">Novastack</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <?php
        use backoffice\src\controller\core\Core;
        $core = new Core;
        echo $core->verModulos();
      ?>
    </ul>
  </div>
</aside>