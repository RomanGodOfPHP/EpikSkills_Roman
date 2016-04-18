<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class){
    require $class.'.php';
});
require 'ty.php';

$connection = new PDO(
    "mysql:host=localhost;dbname=epic;charset=utf8", "root", "vagrant", [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
);
$user = user();
$action = empty($_GET['action']) ? 'home' : $_GET['action'];
switch ($action) {
    case 'login':
        $log = new login($connection);
        $log->authorization();
        break;
    case 'logout':
        $logou = new logout($connection);
        $logou->comeback();
        break;
    case 'save':
        $savemesa = new save($connection);
        $savemesa->savemes();
        break;
    default:
        $defic = new def($connection);
        $defic->defoultt($user);
}