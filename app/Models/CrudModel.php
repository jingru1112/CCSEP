<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * This is a model class for my project.
 */
class CrudModel extends Model
{
    protected $table = 'user_table';

    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'email', 'gender', 'job', 'wage', 'password', 'role'];

    function test() {
        $db = \Config\Database::connect();
        $builder = $db->table('user_table');
        $query = $builder->select('*')->from();
    }

}

?>