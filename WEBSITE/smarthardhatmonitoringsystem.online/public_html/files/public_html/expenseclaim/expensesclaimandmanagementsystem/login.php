<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head><?php include 'header.php'; ?></head>
<body style="background-image: url(images/bg.jpg); width: 100%;background-size: cover;background-position: center;height: 100vh;" class="hold-transition">
 
<div class="container" style="padding-top: 20px;">
  <div class="login-box" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
  <div style="padding: 20px;background-color: #eb6114;color: #fff;box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;color: #fff;">
    <b>LOGIN</b>
  </div>
        <div class="login-box-body" style="padding: 0;box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
          <div style="padding: 20px;padding-top: 50px;padding-bottom: 50px;">
 
      <form action="controller/loginController.php" method="POST">
          <div class="row">
            <div class="col-xs-12">
              <div style="margin-top: 5px;">
                <label>Email</label>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group has-feedback">
                <input type="text" class="form-control" name="email" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div style="margin-top: 5px;">
                <label>Password</label>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" required>
              </div>
            </div>
          </div>
          <div class="row">
            <br>
          <div class="col-xs-12">
            <div style="margin-bottom: 35px;display: none;"><a href="forgotpassword.php" style="float: right;">Forgot Password?</a></div>
                <button type="submit" class="btn btn-block btn-flat" name="login" style="background-color: #eb6114;color: #fff;width: 150px;margin: auto;padding: 10px;"> LOGIN</button>
                <div style="text-align: center;">
                  <br>
                  <a href="forgotpassword.php"> Forgot Password?</a>
                </div>
          </div>
          

          </div>
      </form>
      <br>
    </div>
    </div>
</div>
</div>
	
<?php include 'footer.php'; ?>
</body>
</html>