<link rel="stylesheet" type="text/css" href="../dist/css/style.css">
<aside class="main-sidebar" style="overflow-y: auto;bottom: 0;">
  <section class="sidebar">
    <div class="header" style="background-color: #fff;padding: 10px 5px;text-align: center;">
        <?php
        $sql = "SELECT * FROM users WHERE id = '".$_SESSION['id']."'";
        $stmt = $this->conn()->query($sql);
        $row3 = $stmt->fetch();
        ?>
      <h3 style="font-size: 50px;">
        <img src="../images/logo.png" width="120px">
      </h3>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
      <li><a href="dashboard.php"><i class="fas fa-dashboard"></i> <span>Dashboard</span></a></li>
      <?php if(isset($_SESSION['id']) && $_SESSION['type'] == 'ADMIN'): ?>
      <li><a href="users.php"><i class="fas fa-users"></i> <span>Users</span></a></li>
      <li><a href="employees.php"><i class="fas fa-users"></i> <span>Employees</span></a></li>
      <li><a href="expense_claim_category.php"><i class="fas fa-list"></i> <span>Expense Claim Category</span></a></li>
      <li><a href="leave_category.php"><i class="fas fa-list"></i> <span>Leave Category</span></a></li>
      <?php endif; ?>


      <li><a href="#profile" data-toggle="modal"><i class="fas fa-user"></i> <span>Profile</span></a></li>
      <li><a href="../logout.php"><i class="fas fa-sign-out"></i> <span>Logout</span></a></li>
    
    </ul>
  </section>
  

  
</aside>
