<?php

session_start();

include '../config/config.php';

class Login extends Connection {
  
    public function loginUser() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status']) && isset($_POST['reasonforrejected'])) {

            $id = $_POST['id'];
            $status = $_POST['status'];
            $reasonforrejected = $_POST['reasonforrejected'];

            $sql = "UPDATE reasonforexpenseclaim SET status = ?, reasonforrejected = ? WHERE id = ?";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$status,$reasonforrejected,$id]);

        } else {
        }

    }
}

$login = new Login();
$login->loginUser();

?>
