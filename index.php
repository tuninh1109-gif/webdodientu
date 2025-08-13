<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start(); // Thêm dòng này
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

$controllerName = ucfirst($controller) . 'Controller';
require_once "controllers/{$controllerName}.php";

$ctrl = new $controllerName();
$ctrl->$action();
