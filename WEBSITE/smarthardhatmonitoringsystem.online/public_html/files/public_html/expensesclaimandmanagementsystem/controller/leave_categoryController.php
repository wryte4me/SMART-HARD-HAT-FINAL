<?php
    
    include '../config/config.php';
    session_start();
    class controller extends Connection{

        public function managecontroller(){

            if (isset($_POST['add'])) {

                $category = $_POST['category'];

                $sql = "SELECT * FROM leave_category WHERE category = ?";
                $stmt = $this->conn()->prepare($sql);
                $stmt->execute([$category]);

                if ($stmt->rowcount() > 0) {

                    $_SESSION['error'] = 'error';
                    echo "<script>window.location.href='../admin/leave_category.php';</script>";

                } else {

                    $sqlinsert = "INSERT INTO leave_category (category) VALUES (?)";
                    $statementinsert = $this->conn()->prepare($sqlinsert);
                    $statementinsert->execute([$category]);

                    $_SESSION['success'] = 'success';
                    echo "<script>window.location.href='../admin/leave_category.php';</script>";

                }

            }

            if (isset($_POST['edit'])) {

                $id = $_POST['category_id'];
                $category = $_POST['category'];
    
                $sqlinsert = "UPDATE leave_category SET category = ? WHERE id = '".$id."'";
                $statementinsert = $this->conn()->prepare($sqlinsert);
                $statementinsert->execute([$category]);

                $_SESSION['success'] = 'success';
                echo "<script>window.location.href='../admin/leave_category.php';</script>";
                
            }

            if (isset($_POST['delete'])) {

                $id = $_POST['category_id'];

                $sqlinsert = "DELETE FROM leave_category WHERE id = '".$id."'";
                $statementinsert = $this->conn()->prepare($sqlinsert);
                $statementinsert->execute([]);
           
                $_SESSION['success'] = 'success';
                echo "<script>window.location.href='../admin/leave_category.php';</script>";
                
            }

        }

    }

    $controllerrun = new controller();
    $controllerrun->managecontroller();

?>
