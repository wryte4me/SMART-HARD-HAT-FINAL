<?php

session_start();

include '../config/config.php';

class controller extends Connection {
  
    public function controllerUser() {

        $image = $_FILES['image']['name'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $startdate1 = new DateTime($_POST['startdate']);
        $enddate2 = new DateTime($_POST['enddate']);
        $interval = $startdate1->diff($enddate2);
        $days = $interval->days;
        $reasonforleave = $_POST['reasonforleave'];
        $users_id = $_POST['users_id'];
        $leave_category_id = $_POST['leave_category_id'];

        $imagePath = '../uploads/'.$image;
        $tmp_name = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp_name, $imagePath);

        $id = $_POST['users_id'];

        $sql = "SELECT * FROM employees WHERE id = '".$id."'";
        $stmt = $this->conn()->query($sql);
        $row = $stmt->fetch();

        if ($days > $row['leave_balance']) {
            $response = [
                'success' => false,
                'message' => 'Your Request Leave Is Greate Than To Your Balance',
            ];
        } else {

            $sql = "INSERT INTO reasonforleave (users_id,leave_category_id,startdate,enddate,days,reasonforleave,image) VALUES (?,?,?,?,?,?,?)";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$users_id,$leave_category_id,$startdate,$enddate,$days,$reasonforleave,$image]);

            $response = [
                'success' => true,
                'message' => 'Success Leave Request',
            ];

        }

        header('Content-Type: application/json');
        echo json_encode($response);

    }
}


$controller = new controller();
$controller->controllerUser();

?>


