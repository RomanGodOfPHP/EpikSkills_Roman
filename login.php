<?php
class login
{
    protected $connection;

    public function __construct($connection = "")
    {
        $this->connection = $connection;
    }
    public function authorization(){
        $login = empty($_REQUEST['login']) ? null : $_REQUEST['login'];
        $password = empty($_REQUEST['password']) ? null : $_REQUEST['password'];
        $token = empty($_REQUEST['token']) ? null : $_REQUEST['token'];

        $user = user();
        if (!empty($_REQUEST['action']) && $_REQUEST['action'] === 'login' && valid_token($token)) {
            $user = user($this->connection, $login, $password);
        }

        if (empty($user)) {
            echo template('tyverst.php', [
                'token' => token(),
                'login' => $login,
            ]);
            exit();
        }
        header('Location: indexR.php');
    }
}