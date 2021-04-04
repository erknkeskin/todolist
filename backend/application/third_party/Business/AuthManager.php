<?php

require 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;

class AuthManager
{
    private $authDal;
    private $ci;

    public function __construct(MysqlAuthDal $authDal)
    {
        $this->ci =& get_instance();
        $this->authDal = $authDal;
    }

    public function login()
    {
        $postData = get_all_post_data();

        if (!isset($postData['user_email']) || !email_validate($postData['user_email'])) {
            return array(
                'status' => 'error',
                'type' => 'type_error',
                'message' => 'E-posta hatalıdır'
            );
        }

        if (!isset($postData['user_pass']) || $postData['user_pass'] == '') {
            return array(
                'status' => 'error',
                'type' => 'required_error',
                'message' => 'Şifre yazmalısınız'
            );
        }

        $r = $this->authDal->login($postData);

        $user_data = array(
            'user_id' => $r->user_id,
            'user_fullname' => $r->user_fullname,
            'user_email' => $r->user_email,
            'exp' => time() + 1440
        );

        $token = JWT::encode($user_data, JWT_SECRET);

        if ($r !== false) {
            return array(
                'status' => 'ok',
                'message' => 'Giriş başarılı',
                'token' => $token,
                'user_data' => $user_data
            );
        } else {
            return array(
                'status' => 'error',
                'message' => 'Giriş başarısız'
            );
        }
    }

    public function is_authorize($user_id, $token)
    {
        try {
            $token_data = JWT::decode($token, JWT_SECRET, array('HS256'));

            return $token_data->user_id != $user_id ? false : true;

        } catch (ExpiredException $e) {
            return false;
        } catch (DomainException $e) {
            return false;
        }
    }

    public function user()
    {
        try {
            $token = $this->ci->input->get('token');
            if (!isset($token) || $token == '') {
                return array(
                    'status' => 'header_error',
                    'message' => 'Yetkisiz erişim isteği'
                );
            }

            $token_data = JWT::decode($token, JWT_SECRET, array('HS256'));

            return array(
                'status' => 'ok',
                'token_data' => $token_data
            );

        } catch (ExpiredException $e) {
            return array(
                'status' => 'expired_error',
                'message' => 'Oturum süresi doldu'
            );
        } catch (DomainException $e) {
            return array(
                'status' => 'token_error',
                'message' => 'Token hatalıdır'
            );
        }
    }
}
