<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add New User</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/usersController.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Type</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="type" required>
                        <option value="">Select</option>
                        <option value="Manager">Manager</option>
                        <option value="Employee">Employee</option>
                        <option value="CEO">CEO</option>
                        <option value="HR">HR</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Firstname</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="edit_" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Lastname</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="edit_" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="edit_" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-flat" name="add" style="background-color: #eb6114;color: #fff;"><i class="fa fa-save"></i> Save</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Edit Faculty</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/usersController.php" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Type</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_type" name="type" required>
                        <option value="">Select</option>
                        <option value="Manager">Manager</option>
                        <option value="Employee">Employee</option>
                        <option value="CEO">CEO</option>
                        <option value="HR">HR</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Firstname</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="edit_firstname" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Lastname</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="edit_lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/usersController.php">
                <input type="hidden" name="id" id="delete_id">
                <div class="text-center">
                    <p>DELETE FACULTY</p>
                    <h2 class="bold catname"></h2>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
              </form>
            </div>
        </div>
    </div>
</div>

