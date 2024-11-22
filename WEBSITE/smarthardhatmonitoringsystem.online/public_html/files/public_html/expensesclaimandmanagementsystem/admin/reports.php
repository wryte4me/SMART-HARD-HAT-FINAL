<?php session_start(); ?>

<?php
  include '../config/config.php';
  class category extends Connection{ 
      public function managecategory(){ 
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
        Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!--li>Products</li-->
        <li class="active">Reports</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="../controller/reportsController.php" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel"></i> Excel Reports</a>
            </div>
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Project Name</th>
                  <th>Client Name</th>
                  <th>Location</th>
                  <th>Cost</th>
                  <th>Deadline</th>
                </thead>
                <tbody>


<?php
  


          $sql = "SELECT * FROM project_list INNER JOIN project_payment ON project_list.id=project_payment.project_list_id WHERE status = 2";
          $stmt = $this->conn()->query($sql);
          while ($row = $stmt->fetch()) { ?>
        
                          <tr>
                            <td><?php echo $row['project_name'] ?></td>
                            <td><?php echo $row['client_name'] ?></td>
                            <td><?php echo $row['location'] ?></td>
                            <td>₱ <?php echo $row['cost'] ?></td>
                            <td><?php echo date('F j, Y', strtotime($row['deadline'])) ?></td>
                          </tr>
    
                      <?php 

                          }

                      }
                        
                  }

                    $category = new category();
                    $category->managecategory();
                              
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>All rights reserved</b>
        </div>
         <strong>Copyright &copy; 2020 <!--a href="https://www.facebook.com/BermzISware">Bermz ISware Solutions</a--></strong>
    </footer>    <!-- Add -->


</div>
<!-- ./wrapper -->

<?php include 'footer.php'; ?>
<?php include 'modal/project_list_modal.php'; ?>

<!-- Active Script -->
<script>


    $(document).on('click', '#admin_profile', function(e){
    e.preventDefault();
    $('#profile').modal('show');
    var user_id = $(this).data('user_id');
    var name = $(this).data('name');
    var email = $(this).data('email');
    var password = $(this).data('password');


    $('#user_id').val(user_id)
    $('#name').val(name)
    $('#email').val(email)
    $('#password').val(password)


    getRow(id);
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
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>


<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var project_edit_id = $(this).data('project_edit_id');
    var project_name_edit = $(this).data('project_name_edit');
    var client_name_edit = $(this).data('client_name_edit');
    var location_edit = $(this).data('location_edit');
    var deadline_edit = $(this).data('deadline_edit');
    var status_edit = $(this).data('status_edit');


    $('#project_edit_id').val(project_edit_id)
    $('#project_name_edit').val(project_name_edit)
    $('#client_name_edit').val(client_name_edit)
    $('#location_edit').val(location_edit)
    $('#deadline_edit').val(deadline_edit)
    $('#status_edit').val(status_edit)

    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var project_delete_id = $(this).data('project_delete_id');

    $('#project_delete_id').val(project_delete_id)

    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'category_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.catid').val(response.id_menu);
      $('#edit_name').val(response.name_menu);
      $('.catname').html(response.name_menu);
    }
  });
}
</script>
</body>
</html>
