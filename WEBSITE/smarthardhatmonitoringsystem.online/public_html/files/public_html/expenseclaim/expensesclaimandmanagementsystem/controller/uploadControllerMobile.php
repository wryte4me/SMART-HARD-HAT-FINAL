<?php

session_start();

include '../config/config.php';

class controller extends Connection {
  
    public function controllerUser() {

        $image = $_FILES['image']['name'];
        $name = $_POST['name'];

        $imagePath = '../uploads/'.$image;
        $tmp_name = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp_name, $imagePath);


        $sql = "INSERT INTO upload (name,image) VALUES (?,?)";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute([$name,$image]);

       
    }
}


$controller = new controller();
$controller->controllerUser();

?>


