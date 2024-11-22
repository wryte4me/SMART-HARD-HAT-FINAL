<?php
    
    include '../config/config.php';
    session_start();
    class controller extends Connection{

        public function managecontroller(){

            $sessionId = $_GET['sessionId'];

            $sql = "SELECT *,reasonforleave.id as reasonforleave_id FROM reasonforleave INNER JOIN users ON reasonforleave.users_id=users.id WHERE reasonforleave.users_id = '".$sessionId."'";
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
