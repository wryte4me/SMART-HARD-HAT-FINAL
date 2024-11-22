<?php
    
    include '../config/config.php';
    session_start();
    class controller extends Connection{

        public function managecontroller(){

            if (isset($_POST['add'])) {

                $number = $_POST['number'];
                $department = $_POST['department'];
                $position = $_POST['position'];
                $leave_balance = $_POST['leave_balance'];
                

                $sql = "SELECT * FROM employees WHERE number = ?";
                $stmt = $this->conn()->prepare($sql);
                $stmt->execute([$number]);

                if ($stmt->rowcount() > 0) {

                    $_SESSION['error'] = 'error';
                    echo "<script>window.location.href='../admin/employees.php';</script>";

                } else {

                    $sqlinsert = "INSERT INTO employees (number,department,position,leave_balance) VALUES (?,?,?,?)";
                    $stmt = $this->conn()->prepare($sqlinsert);
                    $stmt->execute([$number,$department,$position,$leave_balance]);



                    $_SESSION['success'] = 'success';
                    echo "<script>window.location.href='../admin/employees.php';</script>";

                }

            }

            if (isset($_POST['edit'])) {

                $id = $_POST['id'];
                $number = $_POST['number'];
                $department = $_POST['department'];
                $position = $_POST['position'];
                $leave_balance = $_POST['leave_balance'];


                $sqlinsert = "UPDATE employees SET number = ?, department = ?, position = ?, leave_balance = ? WHERE id = '".$id."'";
                $stmt = $this->conn()->prepare($sqlinsert);
                $stmt->execute([$number,$department,$position,$leave_balance]);

                $_SESSION['success'] = 'success';
                echo "<script>window.location.href='../admin/employees.php';</script>";
                
            }

            if (isset($_POST['delete'])) {

                $id = $_POST['id'];

                $sqlinsert = "DELETE FROM employees WHERE id = '".$id."'";
                $stmt = $this->conn()->prepare($sqlinsert);
                $stmt->execute([]);
           
                $_SESSION['success'] = 'success';
                echo "<script>window.location.href='../admin/employees.php';</script>";
                
            }

        }

    }

    $controllerrun = new controller();
    $controllerrun->managecontroller();

?>
