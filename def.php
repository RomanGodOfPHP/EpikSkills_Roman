<?php
class def extends login
{
    public function __construct($connection)
    {
        parent::__construct($connection);
    }
    public function defoultt($user)
    {
        if (empty($user)) {
            header('Location: indexR.php?action=login');
        }

        $a = load_count($this->connection);
        $message_id = empty($_GET['message_id']) ? null : (int)$_GET['message_id'];
        $messages = load_messages($this->connection, $message_id);

        echo template('tyverst2.php', [
            'a' => $a,
            'messages' => $messages,
            'token' => token(),
            'message_id' => $message_id,
        ]);
    }
}