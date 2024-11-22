<?php
    
    include '../config/config.php';
    session_start();
    class users extends Connection{

        public function manageusers(){


            if (isset($_POST['save'])) {

                $user_id = $_SESSION['id'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $passwordtxt = $_POST['password'];

                $sqlinsert = "UPDATE users SET firstname = ?, lastname = ?, email = ?,password = ?, passwordtxt = ? WHERE id = '".$user_id."'";
                $statementinsert = $this->conn()->prepare($sqlinsert);
                $statementinsert->execute([$firstname,$lastname,$email,$password,$passwordtxt]);
                
                $_SESSION['success'] = 'success';

                if ($_SESSION['type'] == 'ADMIN') {

                    echo "<script>window.location.href='../admin/dashboard.php';</script>"; 

                } else {

                    echo "<script>window.location.href='../admin/schedule.php';</script>"; 

                } 
                  
                
            }

        }

    }

    $usersrun = new users();
    $usersrun->manageusers();

?>
