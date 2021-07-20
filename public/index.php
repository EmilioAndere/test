<?php

echo 'Bienvenido';

if($_GET){
    $controller = $_GET['controller'].'Controller';
    $action = $_GET['action'];

    require './Controllers/'.$controller.'.php';

    $instance = new $controller();

    $instance->{$action}();
}
