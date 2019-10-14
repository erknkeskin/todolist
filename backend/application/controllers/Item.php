<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{

    public function index()
    {
        echo "item list";
    }

    public function add()
    {
        echo "item add";
    }

    public function update($id)
    {
        echo "item update " . $id;
    }

    public function delete($id)
    {
        echo "item delete " . $id;
    }
}
