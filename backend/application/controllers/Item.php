<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'third_party/Business/ItemManager.php';
require APPPATH . 'third_party/DataAccess/' . DB_LAYER . '/' . DB_LAYER . 'ItemDal.php';

class Item extends CI_Controller
{

    private $itemManager;
    private $itemDal;
    private $dbLayer;

    public function __construct()
    {
        parent::__construct();
        $this->dbLayer = DB_LAYER . 'ItemDal';
        $this->itemDal = new $this->dbLayer();
        $this->itemManager = new ItemManager($this->itemDal);
    }

    public function index($id)
    {
        output($this->itemManager->list($id));
    }

    public function add()
    {
        output($this->itemManager->add());
    }

    public function update($id)
    {
        output($this->itemManager->update($id));
    }

    public function delete($id)
    {
        output($this->itemManager->delete($id));
    }
}
