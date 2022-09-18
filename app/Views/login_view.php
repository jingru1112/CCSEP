<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<?php
$uri = service('uri');
$session = \Config\Services::session();
$validation =  \Config\Services::validation();
$readonly = '';
$buttonDisable = '';
?>
<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">Payroll</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item ">
                    <a class="nav-link active"  aria-current="page" href="/">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 m-auto">
            <!-- if penalty exists, stop the user from entering the field and pressing the button for however long set in the controller. -->
            <?php
            if ($session->getFlashdata('success')) {
                echo '
            <div class="alert alert-success">' . $session->getFlashdata("success") . '</div>
            ';
            }else if($session->getFlashdata('failed')){
                echo '
            <div class="alert alert-danger">'.$session->getFlashdata("failed").'</div>
            ';
            }

            if($session->getTempdata('penalty')) {
                echo '
                <div class="alert alert-danger">'.$session->getTempdata("penalty").'</div>
                ';
                $readonly = 'readonly';
                $buttonDisable = 'disabled';
            }
            ?>
            <form autocomplete="off" action="<?= base_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Login </h4>
                    </div>
                    <div class="card-body p-5">
                        <div class="form-group pt-3">
                            <label for="email"> Email </label>
                            <input autocomplete="off" type="search" <?= $readonly ?> class="form-control <?php if ($validation->getError('email')) : ?>is-invalid<?php endif ?>" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>" />
                            <?php if ($validation->getError('email')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group pt-3">
                            <label for="password"> Password </label>
                            <input autocomplete="new-password" type="password" <?= $readonly ?> class="form-control <?php if ($validation->getError('password')) : ?>is-invalid <?php endif ?>" name="password" placeholder="Password" value="<?php echo set_value('email'); ?>" />
                            <?php if ($validation->getError('password')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password') ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group pt-5 d-flex justify-content-between align-items-center">
                            <button type="submit" <?= $buttonDisable ?> class="btn btn-success">Login</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>