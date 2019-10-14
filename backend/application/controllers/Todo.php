<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'third_party/Business/TodoManager.php';
require APPPATH . 'third_party/DataAccess/' . DB_LAYER . '/' . DB_LAYER . 'TodoDal.php';

class Todo extends CI_Controller
{

    private $todoManager;
    private $todoDal;
    private $dbLayer;

    public function __construct()
    {
        parent::__construct();
        $this->dbLayer = DB_LAYER . 'TodoDal';
        $this->todoDal = new $this->dbLayer();
        $this->todoManager = new TodoManager($this->todoDal);
    }

    public function index()
    {
        output($this->todoManager->all());
    }

    public function add()
    {
        output($this->todoManager->add());
    }

    public function update($id)
    {
        output($this->todoManager->update($id));
    }

    public function delete($id)
    {
        output($this->todoManager->delete($id));
    }
}
