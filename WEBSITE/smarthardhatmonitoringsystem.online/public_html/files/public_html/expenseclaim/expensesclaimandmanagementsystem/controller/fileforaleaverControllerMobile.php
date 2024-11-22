<?php
    
    include '../config/config.php';
    session_start();
    class controller extends Connection{

        public function managecontroller(){


            $sql = "SELECT * FROM leave_category";
            $stmt = $this->conn()->query($sql);


            $data = array();

            if ($stmt->rowcount() > 0) {

                while ($row = $stmt->fetch()) {
                    $data[] = $row;
                }
            }
            echo json_encode($data);
          

        }

    }

    $controllerrun = new controller();
    $controllerrun->managecontroller();

?>
