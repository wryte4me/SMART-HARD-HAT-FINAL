<?php
  
  include '../config/config.php';
  session_start();
  
  class login extends Connection{
  
    public function loginuser(){ 

      if (isset($_POST['login'])) {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = ? ";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowcount() > 0) {

          $row = $stmt->fetch();

          if (password_verify($password, $row['password'])) {

              $_SESSION['id'] = $row['id'];
              $_SESSION['type'] = $row['type'];
              header('location:../admin/dashboard.php'); 

          } else {

            $_SESSION['error'] = 'error';
            echo "<script>window.location.href='../login.php';</script>";

          }

        } else {

          $_SESSION['error'] = 'error';
          echo "<script>window.location.href='../login.php';</script>";

        } 
       
      } 
         
    }

  }

  $loginrun = new login();
  $loginrun->loginuser();

?>



