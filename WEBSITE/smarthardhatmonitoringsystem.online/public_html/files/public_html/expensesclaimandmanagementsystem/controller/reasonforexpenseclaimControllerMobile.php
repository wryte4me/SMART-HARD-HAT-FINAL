<?php

session_start();

include '../config/config.php';

class controller extends Connection {
  
    public function controllerUser() {

        $image = $_FILES['image']['name'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];
        $reasonforexpenseclaim = $_POST['reasonforexpenseclaim'];
        $users_id = $_POST['users_id'];
        $expense_claim_category_id = $_POST['expense_claim_category_id'];

        $imagePath = '../uploads/'.$image;
        $tmp_name = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp_name, $imagePath);

        $id = $_POST['users_id'];

        $expense_claim_number = rand(0000000,9999999);




            $sql = "INSERT INTO reasonforexpenseclaim (expense_claim_number,users_id,expense_claim_category_id,startdate,enddate,reasonforexpenseclaim,image) VALUES (?,?,?,?,?,?,?)";
            $stmt = $this->conn()->prepare($sql);
            $stmt->execute([$expense_claim_number,$users_id,$expense_claim_category_id,$startdate,$enddate,$reasonforexpenseclaim,$image]);

            $response = [
                'success' => true,
                'message' => 'Success Leave Request',
            ];

        

        header('Content-Type: application/json');
        echo json_encode($response);

    }
}


$controller = new controller();
$controller->controllerUser();

?>


