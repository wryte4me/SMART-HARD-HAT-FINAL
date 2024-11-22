<?php session_start(); ?>
<!DOCTYPE html>
<html>
<?php include 'header.php'; ?></head>
<body style="background-image: url(images/bg.jpg); width: 100%;background-size: cover;background-position: center;height: 100vh;" class="hold-transition">
 
<div class="container" style="padding-top: 20px;">
  <div class="login-box" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
  <div style="padding: 20px;background-color: #eb6114;color: #fff;color: #fff;">
    <b>Change Password</b>
  </div>
        <div class="login-box-body" style="padding: 0;box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
          <div style="padding: 20px;padding-top: 50px;padding-bottom: 50px;">
 
      <form action="controller/changepasswordController.php" method="POST">
        <input type="hidden" class="form-control" name="code" value="<?php echo $_GET['code'] ?>" required>
          <div class="row">
            <div class="col-xs-12">
              <div style="margin-top: 5px;">
                <label>PASSWORD</label>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div style="margin-top: 5px;">
                <label>CONFIRM PASSWORD</label>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group has-feedback">
                <input type="password" class="form-control" name="confirmpassword" required>
              </div>
            </div>
          </div>
          <div class="row">
            <br>
          <div class="col-xs-12">
                <button type="submit" class="btn btn-block btn-flat" name="changepassword" style="background-color: #eb6114;color: #fff;width: 180px;margin: auto;padding: 10px;"> CHANGE PASSWORD</button>
          </div>
          </div>
      <br>
    </div>
    </div>
</div>
</div>
  <?php include 'footer.php'; ?>
</body>
</html>