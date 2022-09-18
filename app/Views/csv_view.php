<!DOCTYPE html>
<html lang="en">
<?php
$session = \Config\Services::session();
$uri = service('uri');
$validation = \Config\Services::validation();
?>
<head>
    <meta charset="UTF-8">
    <title>Import</title>
    <meta name="description" content="The tiny framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if($session->get('loggedIn')): ?>
        <?php if ($session->get('role') == 1): ?>
            <meta http-equiv="refresh"
                  content="0; url = http://localhost:8080/index.php/crud_view" />
        <?php endif; ?>
    <?php else: ?>
        <meta http-equiv="refresh"
              content="0; url = http://localhost:8080" />
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<?php if($session->get('loggedIn')): ?>
<?php if($session->get('role') == 0): ?>
<nav class="navbar navbar-expand navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">Payroll</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item ">
                    <a class="nav-link <?= ($uri->getSegment(1) == 'crud_view' ? 'active' : null) ?>"  aria-current="page" href="/crud_view">Dashboard</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <strong>Upload CSV File</strong>
        </div>
        <div class="card-body">
            <div class="mt-2">
                <?php
                if($validation->getError('file'))
                {
                    echo "
                        <div class='container'>
                            <div class='alert alert-danger mt-2 text-center '>
                                ".$validation->getError('file')."
                            </div>
                        </div>
                        ";
                }
                ?>
            </div>
            <form action="<?=site_url('import-csv') ?>" method="post" enctype="multipart/form-data">
                <div class="form-group mb-3">
                    <div class="mb-3">
                        <input type="file" name="file" class="form-control" id="file">
                    </div>
                </div>
                <div class="d-grid">
                    <input type="submit" name="submit" value="Upload" class="btn btn-dark" />
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>
</body>
</html>

<style {csp-style-nonce}>
    .container {
        max-width: 500px;
    }
</style>
