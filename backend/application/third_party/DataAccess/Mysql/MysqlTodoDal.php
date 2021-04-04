<?php

require APPPATH . 'third_party/DataAccess/Interfaces/ITodoDal.php';

class MysqlTodoDal implements ITodoDal
{
    private $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function all($user_id)
    {
        $q = $this->ci->db->where('todo_user_id', $user_id)->where('todo_status <>', 0)->order_by('todo_id DESC')
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

        $query = $this->ci->db->where('todo_id', $id)->get('todos');

        if ($query->num_rows() > 0) {
            $q = $this->ci->db->where('todo_id', $id)->update('todos', $data);

            return $q !== false ? true : false;
        } else {
            return false;
        }
    }

    public function delete($todo_id, $todo_user_id)
    {
        $query = $this->ci->db->where('todo_id', $todo_id)->where('todo_user_id', $todo_user_id)->get('todos');

        if ($query->num_rows() > 0) {
            $q = $this->ci->db->where('todo_id', $todo_id)->where('todo_user_id', $todo_user_id)->delete('todos');

            return $q !== false;
        } else {
            return false;
        }
    }

    public function done($todo_id, $todo_user_id, $todo_status)
    {
        $query = $this->ci->db->where('todo_id', $todo_id)->where('todo_user_id', $todo_user_id)->get('todos');

        if ($query->num_rows() > 0) {
            $q = $this->ci->db->where('todo_id', $todo_id)->where('todo_user_id', $todo_user_id)->update('todos', ['todo_status' => $todo_status]);

            return $q !== false;
        } else {
            return false;
        }
    }
}
