<?php include(__DIR__ . '/../../config/public/includes/head.php'); ?>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>

    <?php include(__DIR__ . '/../../config/public/includes/sidebar.php') ?>

    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <?php include(__DIR__ . '/../../config/public/includes/navbar.php') ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h6>Usuários do sistema</h6>
                                </div>
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Nome completo</th>
                                                    <th
                                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Tipo</th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Status</th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Employed</th>
                                                    <th
                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($usuarios as $key => $value) {

                                                    $status = $value['status'] == 'ativo' ? 'bg-gradient-success' : 'bg-gradient-danger';
                                                    $nome = ucfirst($value['nome']);
                                                    $tipo_usuario = ucfirst($value['tipo_usuario']);
                                                    $item = "
                                                            <tr>
                                                                <td>
                                                                    <div>
                                                                        <img src='$value[foto_perfil]' class='avatar avatar-sm me-3' alt='user1'>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class='d-flex px-2 py-1'>
                                                                        <div class='d-flex flex-column justify-content-center'>
                                                                            <h6 class='mb-0 text-sm'>$nome</h6>
                                                                            <p class='text-xs text-secondary mb-0'>$value[email]</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class='text-xs font-weight-bold mb-0'>$tipo_usuario</p>
                                                                </td>
                                                                <td class='text-center text-sm'>
                                                                    <span class='badge badge-sm $status'>$value[status]</span>
                                                                </td>
                                                                <td class='text-center'>
                                                                    <span class='text-secondary text-xs font-weight-bold'></span>
                                                                </td>
                                                                <td class='text-center'>
                                                                    <a href='javascript:;' class='text-secondary font-weight-bold text-xs' data-toggle='tooltip' data-original-title='Edit user'>
                                                                    Edit
                                                                    </a>
                                                                </td>
                                                            </tr>";
                                                }
                                                echo $item;
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include(__DIR__ . '/../../config/public/includes/footer.php'); ?>
</body>

</html>