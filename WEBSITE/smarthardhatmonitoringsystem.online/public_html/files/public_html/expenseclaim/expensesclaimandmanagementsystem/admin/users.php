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
        Users
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-sm btn-flat" style="background-color: #eb6114;color: #fff;">ADD</a> 
            </div>
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>No#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  <?php $sql = "SELECT * FROM users WHERE type != 'ADMIN'";
                  $stmt = $this->conn()->query($sql);
                  $id = 1;
                  while ($row = $stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $row['firstname'] ?> <?php echo $row['lastname'] ?></td>
                      <td><?php echo $row['email'] ?></td>
                      <td><?php echo $row['type'] ?></td>
                      <td>
                        <button class='btn btn-success btn-sm edit btn-flat' 
                        data-edit_id='<?php echo $row['id'] ?>'
                        data-edit_firstname='<?php echo $row['firstname'] ?>'
                        data-edit_lastname='<?php echo $row['lastname'] ?>'
                        data-edit_email='<?php echo $row['email'] ?>'
                        data-edit_type='<?php echo $row['type'] ?>'
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
<?php include 'modal/usersModal.php'; ?>
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
    var edit_firstname = $(this).data('edit_firstname');
    var edit_lastname = $(this).data('edit_lastname');
    var edit_email = $(this).data('edit_email');
    var edit_type = $(this).data('edit_type');


    $('#edit_id').val(edit_id)
    $('#edit_firstname').val(edit_firstname)
    $('#edit_lastname').val(edit_lastname)
    $('#edit_email').val(edit_email)
    $('#edit_type').val(edit_type)



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