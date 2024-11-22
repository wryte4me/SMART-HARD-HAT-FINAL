<?php

session_start();

include '../config/config.php';

class Login extends Connection {
  
    public function loginUser() {

            $sql = "SELECT * FROM users INNER JOIN employees ON users.id=employees.id WHERE users.id = ?";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$_GET['session_id']]);
            $row = $stmt->fetch();

            $response = [
                'success' => true,
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'email' => $row['email'],
                'leave_balance' => $row['leave_balance'],
            ];

        // Set the Content-Type header to application/json
        header('Content-Type: application/json');

        echo json_encode($response);
    }
}


$login = new Login();
$login->loginUser();

?>
