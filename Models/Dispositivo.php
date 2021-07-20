<?php

include 'Conexion.php';

class Dispositivo {

    public $db;

    function __construct()
    {
        $con = new Conexion();
        $this->db = $con->db;
    }

    
    public function getDispositivos($table){
        $query = sprintf("SELECT t.*, d.estacion, d.n_serie FROM dispositivos AS d INNER JOIN d_%s AS t ON d.id = t.id_dispositivo", $table);
        $sth = $this->db->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    private function getTablasDisp(){
        $tablesD = array();
        $query = sprintf("SHOW TABLES");
        $sth = $this->db->prepare($query);
        $sth->setFetchMode(PDO::FETCH_NUM);
        $sth->execute();
        $tables = $sth->fetchAll();
        foreach ($tables as $value) {
            if(str_contains($value[0], 'd_')){
                array_push($tablesD, $value[0]);
            }
        }
        return $tablesD;
    }

    public function getBusqueda($data){
        $resulC = array();
        $sql = "SELECT id FROM dispositivos WHERE n_serie LIKE '%".$data."%' OR estacion LIKE '%".$data."%'";
        // echo $sql;
        $stm = $this->db->prepare($sql);
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $stm->execute();
        $id = $stm->fetchAll();
        // var_dump(count($id));
        $tables = $this->getTablasDisp();
        for ($i=0; $i < count($id); $i++) { 
            // echo $id[$i]['id'];
            foreach($tables as $table){
                $query = "SELECT id_dispositivo FROM ".$table." WHERE id_dispositivo = ".$id[$i]['id'] ;
                $sth = $this->db->prepare($query);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute();
                $res = $sth->fetchAll();
                if(count($res) > 0){
                    $qr = "SELECT t.*, d.n_serie, d.estacion FROM dispositivos AS d INNER JOIN ".$table." AS t ON d.id = t.id_dispositivo WHERE id = ".$id[$i]['id'];
                    $stm = $this->db->prepare($qr);
                    $stm->setFetchMode(PDO::FETCH_ASSOC);
                    $stm->execute();
                    $result = $stm->fetchAll();
                    array_push($result, $table);
                    array_push($resulC, $result);
                }
            }
        }
        return $resulC;
    }

    public function getColumnas($table){
        $table ='d_'.$table;
        $query = "DESCRIBE ".$table;
        $sth = $this->db->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    public function createDispositivo(array $attributes, string $name){
        try{
            $create = "CREATE TABLE d_".$name." ( id_dispositivo int(11), primary key(id_dispositivo), fecha_compra date, ";
            foreach ($attributes as $attr => $type) {
                $create .= $attr.' '.$type.', ';
            }
            
            $create .= 'FOREIGN KEY (id_dispositivo) REFERENCES dispositivos(id) ON DELETE CASCADE ON UPDATE RESTRICT)';
            $sth = $this->db->prepare($create);
            $sth->execute();
            return true;
        }catch(PDOException $e){
            return $e;
        }
        
    }

    public function getOpciones(){
        $sth = $this->db->prepare("SHOW TABLES");
        $sth->setFetchMode(PDO::FETCH_NUM);
        $sth->execute();
        $data = $sth->fetchAll();
        return $data;
    }

    private function createInto(string $tabla, $id, string $atributos, string $valores){
        $qr = "INSERT INTO d_".$tabla." (id_dispositivo, ";
        // var_dump($atributos);
        $attrib = json_decode($atributos);
        
        foreach($attrib as $vals){
            $qr .= $vals.", ";
        }
        $qr = substr($qr, 0, -2);
        $qr .= ') VALUES ('.$id.', ';
        $valus = json_decode($valores);
        foreach($valus as $value){
            $qr .= "'".$value."', ";
        }
        $qr = substr($qr, 0, -2);
        return $qr;
    }

    public function regDispositivo(string $nserie, string $station, string $table, string $attrs, string $values){
        try {
            $query = "INSERT INTO `dispositivos`(`n_serie`, `estacion`) VALUES ('".$nserie."','".$station."')";
            $qr = '';
            $sth = $this->db->prepare($query);
            $sth->execute();
            $id = $this->db->lastInsertId();
            if($id != NULL){
                // var_dump($attrs);
                // var_dump($values);
                $qr = $this->createInto($table, $id, $attrs, $values);
                $qr .= ')';
                // echo $qr;
                $stm = $this->db->prepare($qr);
                $stm->execute();
            }
            return array('resp' => true, 'msg' => "Nuev@ ".$table." registrado");
        } catch (PDOException $e) {
            return array('resp' => false, 'msg' => "Error: ".$e->getMessage());
        }
       
    }

}

?>