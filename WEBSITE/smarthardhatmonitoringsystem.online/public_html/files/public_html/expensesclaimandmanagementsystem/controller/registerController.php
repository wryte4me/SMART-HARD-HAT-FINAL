<?php
    
    include '../config/config.php';
    session_start();
    class staff extends Connection{

        public function managestaff(){

            if (isset($_POST['register'])) {

                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $idnumber = $_POST['idnumber'];
                $password = password_hash($idnumber, PASSWORD_DEFAULT);
                $passwordtxt = $_POST['idnumber'];
                $type = $_POST['type'];

                $sqlselect_users = "SELECT * FROM users WHERE email = ?";
                $stmt = $this->conn()->prepare($sqlselect_users);
                $stmt->execute([$email]);

                if ($stmt->rowcount() > 0) {

                    $_SESSION['error'] = 'error';
                    echo "<script>window.location.href='../register.php';</script>";

                } else {

                    $sql = "UPDATE idnumber SET status = 1 WHERE idnumber = ?";
                    $stmt = $this->conn()->prepare($sql);
                    $stmt->execute([$idnumber]);

                    $sqlinsert = "INSERT INTO users (idnumber,firstname,lastname,email,password,passwordtxt,type) VALUES (?,?,?,?,?,?,?)";
                    $statementinsert = $this->conn()->prepare($sqlinsert);
                    $statementinsert->execute([$idnumber,$firstname,$lastname,$email,$password,$passwordtxt,$type]);

                    $_SESSION['success'] = 'success';
                    echo "<script>window.location.href='../register.php';</script>";

                }

            }

            if (isset($_POST['edit'])) {

                $id = $_POST['edit_id'];
                $name = $_POST['edit_name'];

                    $sqlinsert = "UPDATE users SET name = ? WHERE faculty_id = '".$id."'";
                    $statementinsert = $this->conn()->prepare($sqlinsert);
                    $statementinsert->execute([$name]);
               
                
           
                echo "<script type='text/javascript'>alert('Successfully Edit Faculty');</script>";
                echo "<script>window.location.href='../admin/faculty.php';</script>";
                
            }

            if (isset($_POST['delete'])) {

                $id = $_POST['delete_id'];

                    $sqlinsert = "DELETE FROM users WHERE faculty_id = '".$id."'";
                    $statementinsert = $this->conn()->prepare($sqlinsert);
                    $statementinsert->execute([]);
               
                    echo "<script type='text/javascript'>alert('Successfully Delete Faculty');</script>";
                    echo "<script>window.location.href='../admin/faculty.php';</script>";
                
            }

        }

    }

    $staffrun = new staff();
    $staffrun->managestaff();

?>
