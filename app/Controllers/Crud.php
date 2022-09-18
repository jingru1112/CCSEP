<?php

namespace App\Controllers;

use App\Models\CrudModel;

class Crud extends BaseController
{
    private $user;
    private $session;

    /**
     * Constructor for this class.
     */
    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->user = new CrudModel();
        $this->session = session();

    }

    /**
     * index function which is used to load the data shown in the dashboard.
     *
     * @return string returns a view of 'crud_view' with $data array attached to it.
     */
    function index()
    {

        $crudModel = new CrudModel();

        //fetch single data
        $data['user_data'] = $crudModel->orderBy('id', 'DESC')->paginate(10);

        $data['pagination_link'] = $crudModel->pager;

        return view('crud_view', $data);
    }

    /**
     * wrapper method for login, which returns the 'login_view'
     *
     * @return string
     */
    public function login() {

        return view('login_view');
    }

    /**
     * This function is used for validating the login credentials. If either password or email is wrong, it will prompt an error on screen.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function loginValidate() {
        $attempt = $this->session->get('attempt');
        $attempt += 1;
        $this->session->set('attempt', $attempt);
        $ttl = 10;
        if($attempt > 3) {
            session()->setTempdata('penalty', 'Too many attempts. Please wait for '.$ttl.' seconds.', $ttl);
            $attempt = 0;
            $this->session->set('attempt', $attempt);
        }

        $inputs = $this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]|alpha_numeric'
        ]);

        if (!$inputs) {
            return view('login_view', [
                'validation' => $this->validator
            ]);
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->user->where('email', $email)->first();
        if ($user) {

            $pass = $user['password'];
            $authPassword = password_verify($password, $pass);

            if ($authPassword) {
                $sessionData = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'gender' => $user['gender'],
                    'job' => $user['job'],
                    'wage' => $user['wage'],
                    'role' => $user['role'],
                    'loggedIn' => true,
                ];

                $this->session->set($sessionData);
                return redirect()->to('crud_view');
            }
            session()->setFlashdata('failed', 'Wrong credential. Please double check your email and password');
            return redirect()->to(site_url('/'));
        }
        session()->setFlashdata('failed', 'Wrong credential. Please double check your email and password');
        return redirect()->to(site_url('/'));
    }

    /**
     * Wrapper method for importing the csv file. Returns a 'csv_view' view.
     * @return string
     */
    public function importCsv() {
        return view('csv_view');
    }

    /**
     * Function for importing the csv file to the database. If either one of the following validation in line 116 is wrong, an error will be prompted.
     * Once the validation has been made, the content of the file is then stored in the database. A sample file is included in the ZIP folder called records.csv
     * @throws \ReflectionException
     */
    public function importCsvToDb() {
        helper('filesystem');
        $input = $this->validate([
            'file'=>'uploaded[file]|max_size[file,2048]|ext_in[file,csv]',
        ]);

        if (!$input) {
            $data['validation'] = $this->validator;
            return view('csv_view', $data);
        }
        else
        {
            if($file = $this->request->getFile('file'))
            {
                if($file->isValid() && !$file->hasMoved())
                {
                    $newName = $file->getRandomName();
                    $file->move('../public/csvfile', $newName);
                    $file = fopen("../public/csvfile/".$newName, "r");
                    $i = 0;
                    $numberOfFields = 6;
                    $csvArr = array();
                    while(($filedata = fgetcsv($file, 1000, ",")) !== false)
                    {
                        $num = count($filedata);
                        if($i > 0 && $num == $numberOfFields)
                        {
                            $csvArr[$i]['name'] = $filedata[0];
                            $csvArr[$i]['email'] = $filedata[1];
                            $csvArr[$i]['gender'] = $filedata[2];
                            $csvArr[$i]['job'] = $filedata[3];
                            $csvArr[$i]['wage'] = $filedata[4];
                            $csvArr[$i]['password'] = $filedata[5];
                        }
                        $i++;
                    }
                    fclose($file);

                    $count = 0;
                    foreach($csvArr as $userdata)
                    {
                        $user = new CrudModel();
                        $findRecord = $user->where('email', $userdata['email'])->countAllResults();
                        if($findRecord == 0)
                        {
                            if($user->insert($userdata))
                            {
                                $count++;
                            }
                        }
                    }
                    session()->setFlashdata('success', $count.' rows successfully added.');
                }
                else
                {
                    session()->setFlashdata('failed', 'CSV file could not be imported');

                }
            }
            else
            {
                session()->setFlashdata('failed', 'CSV file could not be imported.');

            }
        }
        return redirect()->to(site_url('/crud_view'));
    }

    /**
     * Wrapper method for creating an employee. Returns a view called 'add_data'
     * @return string
     */
    function add()
    {
        return view('add_data');
    }

    /**
     * Function used to validate the data during the creation of an account. If any of the rules stated in line 202 to 208 are violated, an error  will be prompted.
     * Once the data has been validated, it will then be stored to the database and shown in the dashboard.
     * @return \CodeIgniter\HTTP\ResponseInterface|void
     * @throws \ReflectionException
     */
    function add_validation()
    {
        helper(['form', 'url']);

        $error = $this->validate([
            'name' 	=> 'required|min_length[3]|alpha_space',
            'email' => 'required|valid_email',
            'gender'=> 'required',
            'job' => 'required|alpha',
            'wage' => 'required|numeric',
            'password' => 'required|min_length[8]|alpha_numeric',
        ]);

        if(!$error)
        {
            echo view('add_data', [
                'error' => $this->validator
            ]);
        }
        else
        {
            $crudModel = new CrudModel();

            $crudModel->save([
                'name'   => $this->request->getVar('name'),
                'email'  => $this->request->getVar('email'),
                'gender'  => $this->request->getVar('gender'),
                'job' => $this->request->getVar('job'),
                'wage' => $this->request->getVar('wage'),
                'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            ]);

            $session = \Config\Services::session();

            $session->setFlashdata('success', 'User Data Added');

            return $this->response->redirect(site_url('/crud'));
        }

    }

    /**
     * Method used to fetch a single user data. This is used for editing the information of that specific user.
     * @param null $id
     * @return string
     */
    function fetch_single_data($id = null)
    {
        $crudModel = new CrudModel();

        $data['user_data'] = $crudModel->where('id', $id)->first();

        return view('edit_data', $data);
    }

    /**
     * Method used for validating the changes made during an edit. An error will be prompted if any of the rules are violated (line 263 to 269)
     * Stores the changes in the database and reflect it on the dashboard.
     * @return \CodeIgniter\HTTP\ResponseInterface|void
     * @throws \ReflectionException
     */
    function edit_validation()
    {
        helper(['form', 'url']);

        $error = $this->validate([
            'name' 	=> 'required|min_length[3]|alpha_space',
            'email' => 'required|valid_email',
            'gender'=> 'required',
            'job' => 'required|alpha',
            'wage' => 'required|numeric',
            'password' => 'required|min_length[8]|alpha_numeric',
        ]);

        $crudModel = new CrudModel();

        $id = $this->request->getVar('id');

        if(!$error)
        {
            $data['user_data'] = $crudModel->where('id', $id)->first();
            $data['error'] = $this->validator;
            echo view('edit_data', $data);
        }
        else
        {
            $data = [
                'name' => $this->request->getVar('name'),
                'email'  => $this->request->getVar('email'),
                'gender'  => $this->request->getVar('gender'),
                'job' => $this->request->getVar('job'),
                'wage' => $this->request->getVar('wage'),
                'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            ];

            $crudModel->update($id, $data);

            $session = \Config\Services::session();

            $session->setFlashdata('success', 'User Data Updated');

            return $this->response->redirect(site_url('/crud'));
        }
    }

    /**
     * Function for deleting an entry. It takes in an id variable, and delete the entry based on the id. Used in 'crud_view.php'
     * @param $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    function delete($id)
    {
        $crudModel = new CrudModel();

        $crudModel->where('id', $id)->delete($id);

        $session = \Config\Services::session();

        $session->setFlashdata('success', 'User Data Deleted');

        return $this->response->redirect(site_url('/crud'));
    }

    /**
     * A logout function. Destroys the session when the logout button is pressed.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(site_url('/'));
    }
}

?>