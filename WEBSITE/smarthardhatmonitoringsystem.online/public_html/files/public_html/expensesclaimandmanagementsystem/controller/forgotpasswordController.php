<?php

    use PHPMailer\PHPMailer\PHPMailer;

    require_once "../sendphpmailer/PHPMailer.php";
    require_once "../sendphpmailer/SMTP.php";
    require_once "../sendphpmailer/Exception.php";


    include '../config/config.php';

    class staff extends Connection{

        public function managestaff(){
            if (isset($_POST['sendemail'])) {

                $email = $_POST['email'];
                $code = rand(000000,999999);

                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = $this->conn()->prepare($sql);
                $stmt->execute([$email]);

                if ($stmt->rowcount() > 0) {

                    $row = $stmt->fetch();

                    $sql = "UPDATE users SET code = ? WHERE email = '".$email."'";
                    $stmt = $this->conn()->prepare($sql);
                    $stmt->execute([$code]);

                    $mail = new PHPMailer();

                    $mail->isSMTP();
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPAuth = true;
                    $mail->Username = "sorar384@gmail.com";
                    $mail->Password = 'ukjqeppzrfugeqgx';
                    $mail->Port = 587;
                    $mail->SMTPSecure = "tls";

                    $mail->isHTML(true);
                    $mail->setFrom('sorar384@gmail.com', 'Change Password');     
                    $mail->addAddress($email);
                    $mail->Subject = "Change Password";
                    $mail->Body    = '
                          <div style="text-align:center;font-size:24px;">
                          Good day!<br><br>
                         <div style="background-color:#10753E;width:500px;margin:auto;color:#fff;font-size:24px;padding:20px 10px;">Click <a href="localhost/expensesclaimandmanagementsystem/changepassword.php?code='.$code.'">here</a> to Change Your Password</div></div>';
                    $mail->send();

                    echo "<script type='text/javascript'>alert('Successfully Send Email');</script>";
                    echo "<script>window.location.href='../login.php';</script>";
                  

                } else {

                    echo "<script type='text/javascript'>alert('Invalid Email');</script>";
                    echo "<script>window.location.href='../forgotpassword.php';</script>";

                } 
               
            } 

        }

    }

    $staffrun = new staff();
    $staffrun->managestaff();

?>
