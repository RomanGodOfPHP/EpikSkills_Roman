<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$connection = new PDO(
    "mysql:host=localhost;dbname=epic;charset=utf8", "root", "vagrant",[
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
);

function insert_message(\PDO $connection, $message, $user_id, $time = null)
{
    if (empty($message)) {
        return false;
    }

    $params = [
        'message' => $message,
        'user_id' => $user_id,
    ];

    if (empty($time)) {
        $query = $connection->prepare('INSERT INTO `messages` SET `message`=:message, `time`=NOW(), `user_id`=:user_id');
    } else {
        $params['time'] = date('Y-m-d H:i:s', $time);
        $query = $connection->prepare('INSERT INTO `messages` SET `message`=:message, `time`=:time, `user_id`=:user_id');
    }
    return $query->execute($params);
}

function update_message(\PDO $connection, $message, $message_id)
{
    if (empty($message)) {
        return false;
    }

    $query = $connection->prepare('UPDATE `messages` SET `message`=:message WHERE `id`=:message_id');
    return $query->execute([
        'message' => $message,
        'message_id' => $message_id
    ]);
}

function load_messages(\PDO $connection, $message_id = null)
{
    if ($message_id !== null) {
        $message_id = (int)$message_id;
    }
    if (empty($_GET['page']) or ($_GET['page'] <= 0)){
        $f = 0;
    } else {
        $f = ((int)($_GET['page']) - 1) * 10;
    }
    return
        $message_id === null
            ? $connection->query("SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` where m.`user_id` = u.`id` ORDER BY m.`time` DESC limit {$f},10")->fetchAll()
            : $connection->query("SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` WHERE m.`id`={$message_id} ORDER BY m.`time` DESC")->fetchAll();
}

function load_count(\PDO $connection){
    $colich = $connection->query('SELECT count(*) as `count` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` where m.`user_id` = u.`id`')->fetch();
    return $a = ceil((int)$colich['count'] / 10);
}

function template($name, array $vars = [])
{
    if (!is_file($name)) {
        throw new exception("Could not load template file {$name}");
    }
    ob_start();
    extract($vars);
    require($name);
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
}

function user(\PDO $connection = null, $login = null, $password = null)
{
    if (!empty($_SESSION['user'])) {
        return $_SESSION['user'];
    }
    if (empty($login)) {
        return null;
    }
    $query = $connection->prepare('SELECT * FROM `users` WHERE `login`=:login AND `password`=:password');
    $query->execute([
        ':login' => $login,
        ':password' => md5($password),
    ]);
    $user = $query->fetch();
    if (!empty($user)) {
        $_SESSION['user'] = $user;
    }
    return $user;
}

function token()
{
    $token = uniqid();
    $_SESSION['token'] = $token;
    return $token;
}

function valid_token($token)
{
    return !empty($_SESSION['token']) && $token == $_SESSION['token'];
}
?>