<header class="main-header">
  <nav class="navbar navbar-static-top" style="background-color: unset !important;display: flex;place-items: center;">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <span style="color: white;"><b>Expense Claim and Leave Management System</b></span>
    <div class="navbar-custom-menu" style="display: none;">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <?php $sql = "SELECT * FROM users WHERE id = '".$_SESSION['id']."'";
          $stmt = $this->conn()->query($sql);
          $row = $stmt->fetch(); ?>
        </li>
      </ul>
    </div>
  </nav>
</header>