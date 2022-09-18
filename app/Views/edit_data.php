<!DOCTYPE html>
<html lang="en">
<?php
$uri = service('uri');
$validation = \Config\Services::validation();
$session = \Config\Services::session();
$readonly = '';
$requestUri = explode('/', $_SERVER['REQUEST_URI'] );
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, user-scalable=yes">
    <?php if($session->get('loggedIn')): ?>
    <?php
    if ($session->get('role') == 1) {
        if ((int)$requestUri[3] !== (int)$session->get('id')) {
            echo '
        <meta http-equiv="refresh"
              content="0; url = http://localhost:8080/crud/fetch_single_data/'.$session->get('id').'" />
        ';
        }
    }
    ?>
    <?php else: ?>
        <meta http-equiv="refresh"
              content="0; url = http://localhost:8080" />
    <?php endif; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Edit</title>
</head>
<body>
<?php if($session->get('loggedIn')): ?>
    <?php if ($session->get('role') == 1): ?>
        <?php if ((int)$requestUri[3] === (int)$session->get('id')): ?>
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
        <h2 class="text-center mt-4 mb-4">Edit Data</h2>
        <div class="card">
            <div class="card-header">Edit Data</div>
            <div class="card-body">
                <form autocomplete="off" method="post" action="<?php echo base_url('crud/edit_validation'); ?>">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <?php if($session->get('role') == 1) {
                            $readonly = 'readonly';
                        } ?>
                        <label>Name</label>
                        <input autocomplete="off" type="search" name="name" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['name']; ?>">
                        <?php
                        if($validation->getError('name'))
                        {
                            echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('name')."
                                </div>
                                ";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input autocomplete="off" type="search" name="email" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['email']; ?>">
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
                        <?php if($session->get('role') == 0): ?>
                        <select name="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Male" <?php if($user_data['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if($user_data['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                        </select>
                        <?php else: ?>
                        <input autocomplete="off" type="search" name="gender" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['gender']; ?>">
                        <?php endif; ?>
                        <?php
                        if($validation->getError('gender'))
                        {
                            echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('gender')."
                                </div>
                                ";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Job</label>
                        <input autocomplete="off" type="search" name="job" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['job']; ?>">
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
                        <input autocomplete="off" type="search" name="wage" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['wage']; ?>">
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
                        <input autocomplete="off" type="password" name="password" class="form-control" value="">
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
                        <input type="hidden" name="id" value="<?php echo $user_data["id"]; ?>" />
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <?php endif; ?>
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
            <h2 class="text-center mt-4 mb-4">Edit Data</h2>
            <div class="card">
                <div class="card-header">Edit Data</div>
                <div class="card-body">
                    <form autocomplete="off" method="post" action="<?php echo base_url('crud/edit_validation'); ?>">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <?php if($session->get('role') == 1) {
                                $readonly = 'readonly';
                            } ?>
                            <label>Name</label>
                            <input autocomplete="off" type="search" name="name" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['name']; ?>">
                            <?php
                            if($validation->getError('name'))
                            {
                                echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('name')."
                                </div>
                                ";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input autocomplete="off" type="search" name="email" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['email']; ?>">
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
                            <?php if($session->get('role') == 0): ?>
                                <select name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php if($user_data['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if($user_data['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                </select>
                            <?php else: ?>
                                <input autocomplete="off" type="search" name="gender" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['gender']; ?>">
                            <?php endif; ?>
                            <?php
                            if($validation->getError('gender'))
                            {
                                echo "
                                <div class='alert alert-danger mt-2'>
                                ".$validation->getError('gender')."
                                </div>
                                ";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Job</label>
                            <input autocomplete="off" type="search" name="job" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['job']; ?>">
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
                            <input autocomplete="off" type="search" name="wage" class="form-control" <?php echo $readonly; ?> value="<?php echo $user_data['wage']; ?>">
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
                            <input autocomplete="off" type="password" name="password" class="form-control" value="">
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
                            <input type="hidden" name="id" value="<?php echo $user_data["id"]; ?>" />
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
</body>
</html>