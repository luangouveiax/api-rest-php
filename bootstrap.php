<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

define('HOST', 'localhost');
define('BANCO', 'projeto_api');
define('USUARIO', 'root');
define('SENHA', '');

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJETO', 'projetoapi');

if(file_exists(filename: 'autoload.php')){
    include('autoload.php');
}else{
    echo "Erro ao incluir bootstrap (config)";
    exit();
}