<?php

class ViewsController {

    public function devices(){
        include 'Views/dispositivos.php';
    }

    public function detail(){
        include 'Views/detalle_dispositivo.php';
    }

    public function img(){
        $name = $_GET['name'];
        echo '<img src="../Assets/'.$name.'" style="width: 100%;" />';
    }

}