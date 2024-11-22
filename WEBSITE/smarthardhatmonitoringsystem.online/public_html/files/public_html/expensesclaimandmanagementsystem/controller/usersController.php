<?php
    
    include '../config/config.php';
    session_start();
    class controller extends Connection{

        public function managecontroller(){

            if (isset($_POST['add'])) {

                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $passwordtxt = $_POST['password'];
                $type = $_POST['type'];

                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = $this->conn()->prepare($sql);
                $stmt->execute([$email]);

                if ($stmt->rowcount() > 0) {

                    $_SESSION['error'] = 'error';
                    echo "<script>window.location.href='../admin/users.php';</script>";

                } else {

                    $sqlinsert = "INSERT INTO users (firstname,lastname,email,password,passwordtxt,type) VALUES (?,?,?,?,?,?)";
                    $statementinsert = $this->conn()->prepare($sqlinsert);
                    $statementinsert->execute([$firstname,$lastname,$email,$password,$passwordtxt,$type]);


                    $sql = "SELECT * FROM users WHERE type = 'Employee' ORDER BY id DESC";
                    $stmt = $this->conn()->query($sql);
                    $row = $stmt->fetch();
                    $id = $row['id'];

                    $sqlinsert = "INSERT INTO employees (id) VALUES (?)";
                    $stmt = $this->conn()->prepare($sqlinsert);
                    $stmt->execute([$id]);


                    $_SESSION['success'] = 'success';
                    echo "<script>window.location.href='../admin/users.php';</script>";

                }

            }

            if (isset($_POST['edit'])) {

                $id = $_POST['id'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $type = $_POST['type'];

                $sqlinsert = "UPDATE users SET firstname = ?, lastname = ?, email = ?, type = ? WHERE id = '".$id."'";
                $statementinsert = $this->conn()->prepare($sqlinsert);
                $statementinsert->execute([$firstname,$lastname,$email,$type]);

                $_SESSION['success'] = 'success';
                echo "<script>window.location.href='../admin/users.php';</script>";
                
            }

            if (isset($_POST['delete'])) {

                $id = $_POST['id'];

                $sqlinsert = "DELETE FROM users WHERE id = '".$id."'";
                $statementinsert = $this->conn()->prepare($sqlinsert);
                $statementinsert->execute([]);
           
                $_SESSION['success'] = 'success';
                echo "<script>window.location.href='../admin/users.php';</script>";
                
            }

        }

    }

    $controllerrun = new controller();
    $controllerrun->managecontroller();

?>
