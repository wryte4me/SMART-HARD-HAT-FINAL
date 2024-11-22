<?php
    
    include '../config/config.php';
    session_start();
    class controller extends Connection{

        public function managecontroller(){

            $sessionId = $_GET['sessionId'];

            $sql = "SELECT *,reasonforexpenseclaim.id as reasonforexpenseclaim_id FROM reasonforexpenseclaim INNER JOIN users ON reasonforexpenseclaim.users_id=users.id WHERE reasonforexpenseclaim.users_id = '".$sessionId."'";
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
