<?php
class save extends login
{
    public function __construct($connection)
    {
        parent::__construct($connection);
    }
    public function savemes()
    {
        $user_id = $_SESSION['user']['id'];
        $message_id = empty($_REQUEST['message_id']) ? null : (int)$_REQUEST['message_id'];
        $message = empty($_REQUEST['message']) ? null : $_REQUEST['message'];

        if (!empty($message) && valid_token($_REQUEST['token'])) {
            if(isset($message_id)){
                update_message($this->connection, $message, $message_id);
                header("Location: indexR.php?action=tyverst2&message_id=$message_id");}
            else{ insert_message($this->connection, $message, $user_id);
                header('Location: indexR.php');}
        }

        $messages = load_messages($this->connection, $message_id);

        echo template('tyverst2.php', [
            'messages' => $messages,
            'token' => token(),
            'message_id' => $message_id,
        ]);
    }
}