<?php

session_start();

include '../config/config.php';

class Login extends Connection {
  
    public function loginUser() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch();



            if ($user && password_verify($password, $user['password'])) {
                $type = $user['type'];
                $response = [
                    'success' => true,
                    'message' => 'Login successful',
                    'userType' => $type,
                    'sessionId' => $user['id'],
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Invalid email or password'
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Email and password are required'
            ];
        }

        // Set the Content-Type header to application/json
        header('Content-Type: application/json');

        // Encode the response array as JSON and echo it
        echo json_encode($response);
    }
}

$login = new Login();
$login->loginUser();

?>
