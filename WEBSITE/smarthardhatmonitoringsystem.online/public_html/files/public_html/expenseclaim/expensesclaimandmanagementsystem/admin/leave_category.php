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

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Leave Category
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
                  <th>Category</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  <?php $sql = "SELECT * FROM leave_category";
                  $stmt = $this->conn()->query($sql);
                  $id = 1;
                  while ($row = $stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $id; ?></td>
                      <td><?php echo $row['category'] ?></td>
                      <td>
                        <button class='btn btn-success btn-sm edit btn-flat' 
                        data-edit_category_id='<?php echo $row['id'] ?>'
                        data-edit_category='<?php echo $row['category'] ?>'
                        ><i class='fa fa-edit'></i> Edit</button>
                        <button class='btn btn-danger btn-sm delete btn-flat' 
                        data-delete_category_id='<?php echo $row['id'] ?>'
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php include 'footer.php'; ?>
<?php include 'modal/leave_categoryModal.php'; ?>
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
    var edit_category_id = $(this).data('edit_category_id');
    var edit_category = $(this).data('edit_category');

    $('#edit_category_id').val(edit_category_id)
    $('#edit_category').val(edit_category)
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var delete_category_id = $(this).data('delete_category_id');

    $('#delete_category_id').val(delete_category_id)
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