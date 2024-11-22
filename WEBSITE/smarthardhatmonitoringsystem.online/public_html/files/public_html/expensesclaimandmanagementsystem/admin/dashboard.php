<?php session_start(); ?>

<?php
  include '../config/config.php';
  class data extends Connection{ 
      public function managedata(){ 
        $sql = "SELECT COUNT(id) AS totalusers FROM users WHERE type != 'ADMIN'";
        $stmt = $this->conn()->query($sql);
        $row = $stmt->fetch();
        $totalusers = $row['totalusers'];

        $sql = "SELECT COUNT(id) AS totalleave_category FROM leave_category";
        $stmt = $this->conn()->query($sql);
        $row = $stmt->fetch();
        $totalleave_category = $row['totalleave_category'];

        $sql = "SELECT COUNT(id) AS totalexpense_claim_category FROM expense_claim_category";
        $stmt = $this->conn()->query($sql);
        $row = $stmt->fetch();
        $totalexpense_claim_category = $row['totalexpense_claim_category'];

        $sql = "SELECT COUNT(id) AS totalemployees FROM employees";
        $stmt = $this->conn()->query($sql);
        $row = $stmt->fetch();
        $totalemployees = $row['totalemployees'];


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
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content" style="min-height: unset;">
      <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #17a2b8!important;color:#fff;">
              <div class="inner">
                <h3><?php echo $totalusers; ?></h3>

                <p>Total Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: #28a745!important;color:#fff;">
              <div class="inner">
                <h3><?php echo $totalemployees; ?></h3>

                <p>Total Employees</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="employees.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #ffc107!important;color:#000;">
              <div class="inner">
                <h3> <?php echo $totalexpense_claim_category; ?></h3>

                <p>Total Expense Claim Category</p>
              </div>
              <div class="icon">
                <i class="fas fa-list"></i>
              </div>
              <a href="expense_claim_category.php" class="small-box-footer" style="color: #000;">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color: #2196f3!important;color:#fff;">
              <div class="inner">
                <h3> <?php echo $totalleave_category; ?></h3>

                <p>Total Leave Category</p>
              </div>
              <div class="icon">
                <i class="fas fa-list"></i>
              </div>
              <a href="leave_category.php" class="small-box-footer" style="color: #fff;">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
    </section>

    <section class="content">
      <div class="row">
        <?php if($_SESSION['type'] == 'ADMIN'): ?>
        <div class="col-xs-6">
          <div class="box">
            <div class="box-header with-border">
               <h4><b>Leave Category</b></h4>
            </div>
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Category</th>
                  <th>Days</th>
                </thead>
                <tbody>
                  <?php $sql = "SELECT * FROM leave_category";
                  $stmt = $this->conn()->query($sql);
                  while ($row = $stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $row['category'] ?></td>
                      <td>
                        <?php $sql = "SELECT *,SUM(days) AS totaldays FROM reasonforleave WHERE leave_category_id = '".$row['id']."'";
                        $stmt2 = $this->conn()->query($sql);
                        $row2 = $stmt2->fetch(); 
                        echo $row2['totaldays'];
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php if($_SESSION['type'] == 'ADMIN'): ?>
          <div class="col-xs-6">
        <?php endif; ?>
        <?php if($_SESSION['type'] == 'Manager'): ?>
          <div class="col-xs-12">
        <?php endif; ?>        
          <div class="box">
            <div class="box-header with-border">
               <h4><b>Expense Claim Category</b></h4>
            </div>
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Category</th>
                  <th>Amount</th>
                </thead>
                <tbody>
                  <?php $sql = "SELECT * FROM expense_claim_category";
                  $stmt = $this->conn()->query($sql);
                  while ($row = $stmt->fetch()) { ?>
                    <tr>
                      <td><?php echo $row['category'] ?></td>
                      <td>
                        ₱<?php $sql = "SELECT *,SUM(days) AS totaldays FROM reasonforleave WHERE leave_category_id = '".$row['id']."'";
                        $stmt2 = $this->conn()->query($sql);
                        $row2 = $stmt2->fetch(); 
                        echo number_format(15000,2);
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<?php include 'footer.php'; ?>

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
</body>
</html>

<?php } } $data = new data();  $data->managedata(); ?>