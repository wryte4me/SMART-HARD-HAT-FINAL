<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add New Employee</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/employeesController.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Employee Number</label>
                    <div class="col-sm-9">
                      <input class="form-control" name="number" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Department</label>
                    <div class="col-sm-9">
                      <input class="form-control" name="department" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Position</label>
                    <div class="col-sm-9">
                      <input class="form-control" name="position" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Leave Balance</label>
                    <div class="col-sm-9">
                      <input class="form-control" name="leave_balance" required>
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
              <h4 class="modal-title"><b>Edit Employee</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/employeesController.php" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Employee Number</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="edit_number" name="number" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Department</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="edit_department" name="department" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Position</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="edit_position" name="position" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Leave Balance</label>
                    <div class="col-sm-9">
                      <input class="form-control" id="edit_leave_balance" name="leave_balance" required>
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
              <form class="form-horizontal" method="POST" action="../controller/employeesController.php">
                <input type="hidden" name="id" id="delete_id">
                <div class="text-center">
                    <p>DELETE EMPLOYEE</p>
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

