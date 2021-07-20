<?php

require_once 'Models/Dispositivo.php';

class DispositivoController {

    public function getOptions(){
        $options = new Dispositivo();
        $op = $options->getOpciones();
        echo json_encode($op);
    }

    public function getDevice(){
        $table = $_GET['device'];
        $device = new Dispositivo();
        $data = $device->getDispositivos($table);
        echo json_encode($data);
    }

    public function createDevice(){
        $arrAttr = array();
        $cadenaEval = '$arrAttr = [';
        $table = $_GET['table'];
        $types = $_GET['types'];
        $names = $_GET['names'];
        $names = json_decode($names);
        $types = json_decode($types);
        for ($i=0; $i < count($names); $i++) { 
            $cadenaEval .= "'".$names[$i]."' => '".$types[$i]."', ";
        }
        $cadenaEval = substr($cadenaEval, 0,-2);
        $cadenaEval .= '];';
        eval($cadenaEval);
        $device = new Dispositivo();
        $res = $device->createDispositivo($arrAttr, $table);
        if($res === true){
            echo 'Nueva Dispositivo '.$table;
        }else{
            var_dump($res);
        }
    }

    public function getSearch(){
        $device = new Dispositivo();
        $data = $_GET['data'];
        $res = $device->getBusqueda($data);
        echo json_encode($res);
    }

    public function getColumns(){
        $fields = array();
        $device = new Dispositivo();
        $table = $_GET['table'];
        $data = $device->getColumnas($table);
        foreach ($data as $value) {
            array_push($fields, $value['Field']);
        }
        echo json_encode($fields);
    }

    public function intoDevice(){
        $nserie = $_GET['serie'];
        $station = $_GET['station'];
        $table = $_GET['table'];
        $atrs = $_GET['atr'];
        $vals = $_GET['vals'];
        $atrs = substr($atrs, 18, strlen($atrs));
        $vals = substr($vals, 6, strlen($vals));
        $atrs = '['.$atrs;
        $vals = '['.$vals;
        $device = new Dispositivo();
        $qr = $device->regDispositivo($nserie, $station, $table, $atrs, $vals);
        echo json_encode($qr);
    }
}

?>