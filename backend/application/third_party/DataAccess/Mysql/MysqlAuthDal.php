<?php

require APPPATH . 'third_party/DataAccess/Interfaces/IAuthDal.php';

class MysqlAuthDal implements IAuthDal
{

    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function login($data)
    {
        $q = $this->ci->db->where('user_status', 1)
            ->where('user_email', $data['user_email'])
            ->where('user_pass', md5($data['user_pass']))
            ->limit(1)
            ->get('users');

        return $q->num_rows() > 0 ? $q->row() : false;
    }
}
