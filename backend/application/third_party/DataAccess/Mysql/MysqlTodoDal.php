<?php

require APPPATH . 'third_party/DataAccess/Interfaces/ITodoDal.php';

class MysqlTodoDal implements ITodoDal
{
    private $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function all()
    {
        $q = $this->ci->db->where('todo_status', 1)
            ->get('todos');

        return $q->num_rows() > 0 ? $q->result() : false;
    }

    public function add($data)
    {
        $q = $this->ci->db->insert('todos', $data);

        return $q !== false ? true : false;
    }

    public function update($data)
    {
        $id = $data['todo_id'];
        unset($data['todo_id']);

        $q = $this->ci->db->where('todo_id', $id)->update('todos', $data);

        return $q !== false ? true : false;

    }

    public function delete($id)
    {
        $q = $this->ci->db->where('todo_id', $id)->delete('todos');

        return $q !== false ? true : false;
    }
}
