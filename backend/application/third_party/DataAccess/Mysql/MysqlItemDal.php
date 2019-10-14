<?php

require APPPATH . 'third_party/DataAccess/Interfaces/IItemDal.php';

class MySqlItemDal implements IItemDal
{
    private $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function list($id)
    {
        $q = $this->ci->db->where('item_status', 1)
            ->where('item_todo_id', $id)
            ->get('items');

        return $q->num_rows() > 0 ? $q->result() : false;
    }

    public function add($data)
    {
        $q = $this->ci->db->insert('items', $data);

        return $q !== false ? true : false;
    }

    public function update($data)
    {
        $id = $data['item_id'];
        unset($data['item_id']);

        $query = $this->ci->db->where('item_id', $id)->get('items');

        if ($query->num_rows() > 0) {
            $q = $this->ci->db->where('item_id', $id)->update('items', $data);

            return $q !== false ? true : false;
        } else {
            return false;
        }
    }

    public function delete($id)
    {

        $query = $this->ci->db->where('item_id', $id)->get('items');

        if ($query->num_rows() > 0) {
            $q = $this->ci->db->where('item_id', $id)->delete('items');

            return $q !== false ? true : false;
        } else {
            return false;
        }
    }
}
