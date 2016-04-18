<?php
class logout extends login
{
    public function __construct($connection)
    {
        parent::__construct($connection);
    }
    public function comeback()
    {
        if (!empty($_REQUEST['action']) && $_REQUEST['action'] === 'logout' && valid_token($_REQUEST['token'])) {
            unset($_SESSION['user']);
            header('Location: indexR.php');
        }
    }
}