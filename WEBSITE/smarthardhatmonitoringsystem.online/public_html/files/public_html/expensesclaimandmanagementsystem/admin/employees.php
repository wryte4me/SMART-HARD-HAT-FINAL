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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employees
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <!-- <a href="#addnew" data-toggle="modal" class="btn btn-sm btn-flat" style="background-color: #eb6114;color: #fff;">ADD</a>  -->
            </div>
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>No#</th>
                  <th>Name</th>
                  <th>Employee Number</th>
                  <th>Department</th>
                  <th>Position</th>
                  <th>Leave Balance</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  <?php $sql = "SELECT *,employees.id AS employees_id FROM employees INNER JOIN users ON employees.id=users.id";
                  $stmt = $this->conn()->query($sql);
                  $id = 1;
                  while ($row = $stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $row['firstname'] ?> <?php echo $row['lastname'] ?></td>
                      <td><?php echo $row['number'] ?></td>
                      <td><?php echo $row['department'] ?></td>
                      <td><?php echo $row['position'] ?></td>
                      <td><?php echo $row['leave_balance'] ?></td>
                      <td>
                        <button class='btn btn-success btn-sm edit btn-flat' 
                        data-edit_id='<?php echo $row['employees_id'] ?>'
                        data-edit_number='<?php echo $row['number'] ?>'
                        data-edit_department='<?php echo $row['department'] ?>'
                        data-edit_position='<?php echo $row['position'] ?>'
                        data-edit_leave_balance='<?php echo $row['leave_balance'] ?>'
                        ><i class='fa fa-edit'></i> Edit</button>
                        <button class='btn btn-danger btn-sm delete btn-flat' 
                        data-delete_id='<?php echo $row['id'] ?>'
                        ><i class='fa fa-trash'></i> Delete</button>
                      </td>
                    </tr>
    
                  <?php $id++; } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>

</div>
<!-- ./wrapper -->

<?php include 'footer.php'; ?>
<?php include 'modal/employeesModal.php'; ?>
<?php include 'modal/successModal.php'; ?>

<!-- Active Script -->
<script>


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
    
    })
  })
</script>


<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var edit_id = $(this).data('edit_id');
    var edit_number = $(this).data('edit_number');
    var edit_department = $(this).data('edit_department');
    var edit_position = $(this).data('edit_position');
    var edit_leave_balance = $(this).data('edit_leave_balance');

    $('#edit_id').val(edit_id)
    $('#edit_number').val(edit_number)
    $('#edit_department').val(edit_department)
    $('#edit_position').val(edit_position)
    $('#edit_leave_balance').val(edit_leave_balance)

  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var delete_id = $(this).data('delete_id');

    $('#delete_id').val(delete_id)



  });


});


</script>

<script>
  <?php if (isset($_SESSION['success'])) { ?>
    $('#success').modal('show')
  <?php unset($_SESSION['success']); } ?>

  <?php if (isset($_SESSION['success2'])) { ?>
    $('#success2').modal('show')
  <?php unset($_SESSION['success2']); } ?>

  <?php if (isset($_SESSION['error'])) { ?>
    $('#error').modal('show')
  <?php unset($_SESSION['error']); } ?>
</script>
</body>
</html>
<?php
                      }
                        
                  }

                    $data = new data();
                    $data->managedata();
                              
                  ?>