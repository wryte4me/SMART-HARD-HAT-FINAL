<?php

session_start();

include '../config/config.php';

class Login extends Connection {
  
    public function loginUser() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['status']) && isset($_POST['reasonforrejected'])) {

            $id = $_POST['id'];
            $status = $_POST['status'];
            $reasonforrejected = $_POST['reasonforrejected'];

            $sql = "UPDATE reasonforleave SET status = ?, reasonforrejected = ? WHERE id = ?";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$status,$reasonforrejected,$id]);


            $sql = "SELECT * FROM reasonforleave WHERE id = '".$id."'";
            $stmt = $this->conn()->query($sql);
            $row = $stmt->fetch();
            $users_id = $row['users_id'];
            $days = $row['days'];


            $sql = "SELECT * FROM employees WHERE id = '".$users_id."'";
            $stmt = $this->conn()->query($sql);
            $row = $stmt->fetch();

            $leave_balance = $row['leave_balance'] - $days;

            $sql = "UPDATE employees SET leave_balance = ? WHERE id = ?";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$leave_balance,$users_id]);

            

        } else {
        }

    }
}

$login = new Login();
$login->loginUser();

?>
