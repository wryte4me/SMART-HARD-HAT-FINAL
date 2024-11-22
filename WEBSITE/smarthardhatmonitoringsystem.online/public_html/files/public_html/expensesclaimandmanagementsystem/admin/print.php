
<?php
session_start();
  include '../config/config.php';
  class data extends Connection{ 
      public function managedata(){    
     
?>

<style>
  table{
    border-collapse: collapse;
    width: 100%;
  }
  table,th,td{
    padding: 5px;
    border: 1px solid #000;
  }
</style>
 
<div>
  <div>
    <div>
      <div>
        <h3 style="text-align: center;"><strong>
ILOAD: COURSE SCHEDULING SYSTEM FOR BSIT DEPARTMENT RIZAL TECHNOLOGICAL UNIVERSITY</strong></h3>
<h2 style="text-align: center;"><strong>Schedule</strong></h2>
      </div>
      <table>
        <tr>
          <th>Professor</th>
          <th>Course</th>
          <th>Course Code</th>
          <th>Units</th>
          <th>Curiculum</th>
          <th>Program</th>
          <th>Room</th>
          <th>Section</th>
          <th>Day & Time</th>
        </tr>
        <?php

        if ($_SESSION['type'] == 'ADMIN') {

          $sql = "SELECT *,schedule.id as schedule_id FROM schedule INNER JOIN users ON users.id=schedule.professor_id INNER JOIN course ON schedule.course_id=course.id INNER JOIN curiculum ON schedule.curiculum_id=curiculum.id INNER JOIN program ON schedule.program_id=program.id INNER JOIN room ON schedule.room_id=room.id INNER JOIN section ON schedule.section_id=section.id ORDER BY users.lastname ASC";

        } else {

          $sql = "SELECT *,schedule.id as schedule_id FROM schedule INNER JOIN users ON users.id=schedule.professor_id INNER JOIN course ON schedule.course_id=course.id INNER JOIN curiculum ON schedule.curiculum_id=curiculum.id INNER JOIN program ON schedule.program_id=program.id INNER JOIN room ON schedule.room_id=room.id INNER JOIN section ON schedule.section_id=section.id WHERE schedule.professor_id='".$_SESSION['id']."'";

        }
        
        $stmt = $this->conn()->query($sql);
        while ($row = $stmt->fetch()) { ?>
          <tr>
            <td><?php echo $row['firstname'] ?> <?php echo $row['lastname'] ?></td>
            <td><?php echo $row['course'] ?></td>
            <td><?php echo $row['coursecode'] ?></td>
            <td><?php echo $row['units'] ?></td>
            <td><?php echo $row['curiculum'] ?></td>
            <td><?php echo $row['program'] ?></td>
            <td><?php echo $row['room'] ?></td>
            <td><?php echo $row['section'] ?></td>
            <td><?php echo $row['day'] ?> - <?php echo $row['time'] ?></td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>
<script>
  window.print();
  window.onafterprint = window.close; 
</script>




<?php } } $data = new data(); $data->managedata(); ?>

