<?php session_start(); ?>

<?php
  include '../config/config.php';
  class data extends Connection{ 
      public function managedata(){ 

?>
<!DOCTYPE html>
<html>
<head><?php include 'head.php'; ?></head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


<?php include 'navbar.php'; ?>
<?php include 'profile.php'; ?>
<?php include 'sidebar.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="overflow-y: scroll;height: 100vh;padding-bottom: 50px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        APPROVAL REQUESTS
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">APPROVAL REQUESTS</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th></th>
                  <th>Deparment</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>File</th>
                </thead>
                <tbody>
                  <?php $sql = "SELECT * FROM request";
                  $stmt = $this->conn()->query($sql);
                  while ($row = $stmt->fetch()) { ?>
        
                          <tr>
                            <td>
                              <a class="btn btn-success btn-flat" href="approval.php?id=<?php echo $row['id'] ?>" style="color: black;"><b>OPEN FORM</b></a>
                              <button class="btn btn-primary btn-flat approval" data-request_id="<?php echo $row['id'] ?>"><b>Approval</b></button>
                            </td>
                            <td><?php echo $row['department'] ?></td>
                            <td><?php echo $row['datefilled'] ?></td>
                            <td><?php echo $row['status'] ?></td>
                            <td>
                              <a href="../file/<?php echo $row['file'] ?>" target="_blank"><?php echo $row['file'] ?></a>
                            </td>
                          </tr>
    
                      <?php 

                          }
                          ?>



                </tbody>
              </table>

              
              <?php if (isset($_GET['id'])) { ?>
                <br>
              <h2 style="background-color: #000;color: #fff;padding: 5px;"><b>Document</b></h2>
                <?php
                $sql = "SELECT * FROM request WHERE id = '".$_GET['id']."'";
                $stmt = $this->conn()->query($sql);
                $row = $stmt->fetch();
                ?>
              <div class="col-xs-12" style="margin-top: 20px;">
                <embed src="../file/<?php echo $row['file'] ?>" type="application/pdf" width="100%" height="600px" />
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>
         <!-- <embed src="COMMENTS-NA-NEED-MAMEET-SA-SYSTEMUpdated.pdf" type="application/pdf" width="100%" height="600px" /> -->

  </div>


</div>
<!-- ./wrapper -->

<?php include 'footer.php'; ?>
<?php include 'modal/approvalModal.php'; ?>

<!-- Active Script -->
<script>

    $(document).on('click', '#admin_profile', function(e){
    e.preventDefault();
    $('#profile').modal('show');
    var user_id = $(this).data('user_id');
    var firstname = $(this).data('firstname');
    var email = $(this).data('email');
    var password = $(this).data('password');

    $('#user_id').val(user_id)
    $('#firstname').val(firstname)
    $('#email').val(email)
    $('#password').val(password)

  });
$(function(){
  /** add active class and stay opened when selected */
  var url = window.location;
  
  // for sidebar menu entirely but not cover treeview
  $('ul.sidebar-menu a').filter(function() {
      return this.href == url;
  }).parent().addClass('active');

  // for treeview
  $('ul.treeview-menu a').filter(function() {
      return this.href == url;
  }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

});
</script>
<!-- Data Table Initialize -->
<script>
  $(function () {
    $('#example1').DataTable({
      responsive: true
    })
  })

  $('.approval').click(function(){
    $('#approvalModal').modal('show');
    request_id = $(this).data('request_id')
    $('#request_id').val(request_id)
  })
</script>

</body>
</html>
     <?php
                      }
                        
                  }

                    $data = new data();
                    $data->managedata();
                              
                  ?>