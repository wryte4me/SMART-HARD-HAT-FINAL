<div class="modal fade" id="profile">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b> Update  Profile</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/profileController.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Firstname</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="firstname" value="<?php echo $row['firstname'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Lastname</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="lastname" value="<?php echo $row['lastname'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9"> 
                      <input type="password" class="form-control" name="password" value="<?php echo $row['passwordtxt'] ?>">
                    </div>
                </div>
                <hr>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-flat" name="save" style="background-color: #eb6114;color: #fff;"><i class="fa fa-check-square-o"></i> Save</button>
              </form>
            </div>
        </div>
    </div>
</div>