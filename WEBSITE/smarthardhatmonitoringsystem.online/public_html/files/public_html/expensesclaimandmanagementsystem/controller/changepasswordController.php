<?php

    include '../config/config.php';

    class staff extends Connection{

        public function managestaff(){

            if (isset($_POST['changepassword'])) {

                $code = $_POST['code'];

                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $confirmpassword = $_POST['confirmpassword'];
                $passwordtxt = $_POST['password'];

                    if ($_POST['password'] != $confirmpassword) {

                        echo "<script type='text/javascript'>alert('Password Not Match');</script>";
                        echo "<script>window.location.href='../changepassword.php?code=".$code."';</script>";

                    } else {

                        $sql = "UPDATE users SET password = ?, passwordtxt = ? WHERE code = '".$code."'";
                        $stmt = $this->conn()->prepare($sql);
                        $stmt->execute([$password,$passwordtxt]);
                   
                        echo "<script type='text/javascript'>alert('Successfully Change Password');</script>";
                        echo "<script>window.location.href='../login.php';</script>";

                    }
               
            }

        }

    }

    $staffrun = new staff();
    $staffrun->managestaff();

?>
