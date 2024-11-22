<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add New Faculty</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="../controller/facultyController.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Image</label>

                    <div class="col-sm-9">
                      <input type="file" class="form-control" id="img" name="img" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="form-group">
                  <label for="department_id" class="col-sm-3 control-label">Department</label>
                  <div class="col-sm-9">
                  <select class="form-control" id="department_id" name="department_id" required>
                    <option value="">-- Select --</option>
                    <?php 
                      $sql = "SELECT * FROM department";
                      $stmt = $this->conn()->query($sql);
                      while ($row = $stmt->fetch()) { ?>
                      <option value="<?php echo $row['department_id'] ?>"><?php echo $row['department'] ?></option>
                  <?php } ?>
                  </select>
                  </div>
                </div>                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
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
              <form class="form-horizontal" method="POST" action="../controller/facultyController.php" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" id="edit_id">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Image</label>

                    <div class="col-sm-9">
                      <input type="file" class="form-control" id="edit_img" name="edit_img">
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_name" class="col-sm-3 control-label">Name</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_name" name="edit_name" required>
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
              <form class="form-horizontal" method="POST" action="../controller/facultyController.php">
                <input type="hidden" name="delete_id" id="delete_id">
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