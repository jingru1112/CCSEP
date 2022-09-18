<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, user-scalable=yes">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Payroll</title>
</head>
<body>

<?php
$uri = service('uri');
$session = \Config\Services::session();

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
    <br>
    <?php
    if($session->getFlashdata('success'))
    {
        echo '
            <div class="alert alert-success">'.$session->getFlashdata("success").'</div>
            ';
    } elseif ($session->getFlashdata('failed')) {
        echo '
            <div class="alert alert-danger">'.$session->getFlashdata("failed").'</div>
        ';
    }
    ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col"></div>
                <div class="col-md-12 bg-light text-end">
                    <?php if($session->get('role') == 0): ?>
                    <a href="<?php echo base_url("/crud/add")?>" class="btn btn-success btn-sm">Create</a>
                    <a href="<?php echo base_url("/crud/importCsv")?>" class="btn btn-secondary btn-sm">Import</a>
                    <?php else: ?>
                    <br>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Job</th>
                        <th>Wage</th>
                        <?php if ($session->get('role') == 0): ?>
                        <th>Edit</th>
                        <th>Delete</th>
                        <?php else: ?>
                        <th>Edit</th>
                        <?php endif; ?>
                    </tr>
                    <?php if ($session->get('role') == 0): ?>
                        <?php
                        if($user_data)
                        {
                            foreach($user_data as $user)
                            {
                                echo '
                                    <tr>
                                        <td>'.$user["id"].'</td>
                                        <td>'.$user["name"].'</td>
                                        <td>'.$user["email"].'</td>
                                        <td>'.$user["gender"].'</td>
                                        <td>'.$user["job"].'</td>
                                        <td>'.$user["wage"].'</td>
                                        <td><a href="'.base_url().'/crud/fetch_single_data/'.$user["id"].'" class="btn btn-sm btn-warning">Edit</a></td>
                                        <td><button type="button" onclick="delete_data('.$user["id"].')" class="btn btn-danger btn-sm">Delete</button></td>
                                    </tr>';
                            }
                        }
                        ?>
                    <?php else: ?>
                        <?php
                        echo '
                            <tr>
                                <td>'.$session->get("id").'</td>
                                <td>'.$session->get("name").'</td>
                                <td>'.$session->get("email").'</td>
                                <td>'.$session->get("gender").'</td>
                                <td>'.$session->get("job").'</td>
                                <td>'.$session->get("wage").'</td>
                                <td><a href="'.base_url().'/crud/fetch_single_data/'.$session->get("id").'" class="btn btn-sm btn-warning">View</a></td>
                            </tr>';
                        ?>
                    <?php endif; ?>
                </table>
            </div>
            <div>
                <?php if ($session->get('role') == 0): ?>
                <?php
                // This is used for paginate the data, making it 10 per page.
                if($pagination_link)
                {
                    $pagination_link->setPath('crud');

                    echo $pagination_link->links();
                }
                ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<style {csp-style-nonce}>
    .pagination li a
    {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #007bff;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }

    .pagination li.active a {
        z-index: 1;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
<!-- A JS script that prompts an alert box, making sure that the admin wants to delete the entry. -->
<script>
    function delete_data(id) {
        if(confirm("Are you sure you want to remove it?")) {
            window.location.href="<?php echo base_url(); ?>/crud/delete/"+id;
        }
        return false;
    }
</script>