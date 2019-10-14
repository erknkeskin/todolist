<?php

class TodoManager
{

    private $todoDal;

    public function __construct(MysqlTodoDal $todoDal)
    {
        $this->todoDal = $todoDal;
    }

    public function all()
    {
        $r = $this->todoDal->all();

        if ($r !== false) {
            return array(
                'status' => 'ok',
                'data' => $r
            );
        } else {
            return array(
                'status' => 'error',
                'type' => 'data_not_found',
                'message' => 'Kayıt bulunamadı'
            );
        }
    }

    public function add()
    {

        $postData = get_all_post_data();

        if (!isset($postData['todo_user_id']) || !is_numeric($postData['todo_user_id'])) {
            return array(
                'status' => 'error',
                'type' => 'value_error',
                'message' => 'Değer hatalıdır'
            );
        }

        if (!isset($postData['todo_name']) || $postData['todo_name'] == '') {
            return array(
                'status' => 'error',
                'type' => 'required_error',
                'message' => 'Liste adı yazmalısınız'
            );
        }

        $postData['todo_created'] = time();
        $postData['todo_modified'] = time();
        $postData['todo_status'] = 1;

        $r = $this->todoDal->add($postData);

        if ($r !== false) {
            return array(
                'status' => 'ok',
                'message' => 'Liste eklendi'
            );
        } else {
            return array(
                'status' => 'error',
                'type' => 'data_not_saved',
                'message' => 'Liste eklenemedi'
            );
        }
    }

    public function update($id)
    {
        $postData = (array)json_decode(file_get_contents("php://input"));

        if (!isset($postData['todo_user_id']) || !is_numeric($postData['todo_user_id'])) {
            return array(
                'status' => 'error',
                'type' => 'value_error',
                'message' => 'Değer hatalıdır'
            );
        }

        if (!isset($postData['todo_name']) || $postData['todo_name'] == '') {
            return array(
                'status' => 'error',
                'type' => 'required_error',
                'message' => 'Liste adı yazmalısınız'
            );
        }

        $postData['todo_id'] = $id;
        $postData['todo_modified'] = time();
        $postData['todo_status'] = 1;

        $r = $this->todoDal->update($postData);

        if ($r !== false) {
            return array(
                'status' => 'ok',
                'message' => 'Liste güncellendi'
            );
        } else {
            return array(
                'status' => 'error',
                'type' => 'data_not_updated',
                'message' => 'Liste güncellenemedi'
            );
        }
    }

    public function delete($id)
    {
        $r = $this->todoDal->delete($id);

        if ($r !== false) {
            return array(
                'status' => 'ok',
                'message' => 'Liste silindi'
            );
        } else {
            return array(
                'status' => 'error',
                'type' => 'data_not_deleted',
                'message' => 'Liste silinemedi'
            );
        }
    }
}
