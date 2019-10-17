<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'third_party/Business/AuthManager.php';
require APPPATH . 'third_party/DataAccess/' . DB_LAYER . '/' . DB_LAYER . 'AuthDal.php';

class Auth extends CI_Controller
{

    private $authDal;
    private $authManager;
    private $dbLayer;

    public function __construct()
    {
        parent::__construct();
        $this->dbLayer = DB_LAYER . 'AuthDal';
        $this->authDal = new $this->dbLayer();
        $this->authManager = new AuthManager($this->authDal);
    }

    public function login()
    {
        output($this->authManager->login());
    }

    public function user()
    {
        output($this->authManager->user());
    }
}
