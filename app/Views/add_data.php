<!DOCTYPE html>
<html lang="en">
<?php
$uri = service('uri');
$validation = \Config\Services::validation();
$session = \Config\Services::session();
?>
<!-- Only display the code when the session is logged in. -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <?php if($session->get('loggedIn')): ?>
    <!-- admin = 0, user = 1 -->?
        <?php if($session->get('role') == 1): ?>
        <meta http-equiv="refresh"
              content="0; url = http://localhost:8080/index.php/crud_view" />
        <?php endif; ?>
    <?php else: ?>
        <meta http-equiv="refresh"
              content="0; url = http://localhost:8080" />
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Add</title>
</head>
<body>
<?php if($session->get('loggedIn')): ?>
    <?php if($session->get('role') == 1): ?>
    <!--<h3>You're in the wrong page. You will be redirected back to the dashboard in 5 seconds. </br> If you're not redirected in 5 seconds, <a href="http://localhost:8080/index.php/crud_view">click here.</a></h3>-->
    <?php else: ?>
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
    <div class="container">
        <h2 class="text-center mt-4 mb-4">Add Data</h2>
        <div class="card">
            <div class="card-header">Add Data</div>
            <div class="card-body">
                <form autocomplete="off" method="post" action="<?php echo base_url("/crud/add_validation")?>">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label>Name</label>
                        <input autocomplete="off" type="search" name="name" class="form-control" />
                        <?php
                        if($validation->getError('name'))
                        {
                            echo '<div class="alert alert-danger mt-2">'.$validation->getError('name').'</div>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input autocomplete="off" type="search" name="email" class="form-control" />
                        <?php
                        if($validation->getError('email'))
                        {
                            echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('email')."
                                </div>
                                ";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <?php
                        if($validation->getError('gender'))
                        {
                            echo '<div class="alert alert-danger mt-2">
                                '.$validation->getError("gender").'
                                </div>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Job</label>
                        <input autocomplete="off" type="search" name="job" class="form-control" />
                        <?php
                        if($validation->getError('job'))
                        {
                            echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('job')."
                                </div>
                                ";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Wage</label>
                        <input autocomplete="off" type="search" name="wage" class="form-control" />
                        <?php
                        if($validation->getError('wage'))
                        {
                            echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('wage')."
                                </div>
                                ";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input autocomplete="chrome-off" type="password" name="password" class="form-control" />
                        <?php
                        if($validation->getError('password'))
                        {
                            echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('password')."
                                </div>
                                ";
                        }
                        ?>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php endif; ?>
<?php endif; ?>
</body>
</html>