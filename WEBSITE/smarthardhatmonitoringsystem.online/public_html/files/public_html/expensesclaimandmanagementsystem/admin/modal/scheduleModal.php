<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Add New Schedule</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/scheduleController.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Professor</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="professor_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM users WHERE type = 'PROFESSOR'";
                        $stmt = $this->conn()->query($sql);
                        while ($row1 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row1['id'] ?>"><?php echo $row1['firstname'] ?> <?php echo $row1['lastname'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Course</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="course_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM course";
                        $stmt = $this->conn()->query($sql);
                        while ($row2 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row2['id'] ?>"><?php echo $row2['course'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Curiculum</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="curiculum_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM curiculum";
                        $stmt = $this->conn()->query($sql);
                        while ($row3 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row3['id'] ?>"><?php echo $row3['curiculum'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Program</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="program_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM program";
                        $stmt = $this->conn()->query($sql);
                        while ($row4 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row4['id'] ?>"><?php echo $row4['program'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Room</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="room_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM room";
                        $stmt = $this->conn()->query($sql);
                        while ($row5 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row5['id'] ?>"><?php echo $row5['room'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Section</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="section_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM section";
                        $stmt = $this->conn()->query($sql);
                        while ($row6 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row6['id'] ?>"><?php echo $row6['section'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Day</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="day" required>
                        <option value="">Select</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Time</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="time" required>
                        <option value="">Select</option>
                        <option value="7:00 - 7:30 AM">7:00 - 7:30 AM</option>
                        <option value="7:30 - 8:00 AM">7:30 - 8:00 AM</option>
                        <option value="8:00 - 8:30 AM">8:00 - 8:30 AM</option>
                        <option value="8:30 - 9:00 AM">8:30 - 9:00 AM</option>
                        <option value="9:00 - 9:30 AM">9:00 - 9:30 AM</option>
                        <option value="9:30 - 10:00 AM">9:30 - 10:00 AM</option>
                        <option value="10:00 - 10:30 AM">10:00 - 10:30 AM</option>
                        <option value="10:30 - 11:00 AM">10:30 - 11:00 AM</option>
                        <option value="11:00 - 11:30 AM">11:00 - 11:30 AM</option>
                        <option value="11:30 - 12:00 PM">11:30 - 12:00 PM</option>
                        <option value="12:00 - 12:30 PM">12:00 - 12:30 PM</option>
                        <option value="12:30 - 1:00 PM">12:30 - 1:00 PM</option>
                        <option value="1:00 - 1:30 PM">1:00 - 1:30 PM</option>
                        <option value="1:30 - 2:00 PM">1:30 - 2:00 PM</option>
                        <option value="2:00 - 2:30 PM">2:00 - 2:30 PM</option>
                        <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                        <option value="3:00 - 3:30 PM">3:00 - 3:30 PM</option>
                        <option value="3:30 - 4:00 PM">3:30 - 4:00 PM</option>
                        <option value="4:00 - 4:30 PM">4:00 - 4:30 PM</option>
                        <option value="4:30 - 5:00 PM">4:30 - 5:00 PM</option>
                        <option value="5:00 - 5:30 PM">5:00 - 5:30 PM</option>
                        <option value="5:30 - 6:00 PM">5:30 - 6:00 PM</option>
                        <option value="6:00 - 6:30 PM">6:00 - 6:30 PM</option>
                        <option value="6:30 - 7:00 PM">6:30 - 7:00 PM</option>

                      </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-flat" name="add" style="background-color: #E5EE7F;"><i class="fa fa-save"></i> Save</button>
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
              <h4 class="modal-title"><b>Edit Schedule</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/scheduleController.php" enctype="multipart/form-data">
                <input type="hidden" id="edit_id" name="id">
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Professor</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_professor_id" name="professor_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM users WHERE type = 'PROFESSOR'";
                        $stmt = $this->conn()->query($sql);
                        while ($row1 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row1['id'] ?>"><?php echo $row1['firstname'] ?> <?php echo $row1['lastname'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Course</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_course_id" name="course_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM course";
                        $stmt = $this->conn()->query($sql);
                        while ($row2 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row2['id'] ?>"><?php echo $row2['course'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Curiculum</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_curiculum_id" name="curiculum_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM curiculum";
                        $stmt = $this->conn()->query($sql);
                        while ($row3 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row3['id'] ?>"><?php echo $row3['curiculum'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Program</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_program_id" name="program_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM program";
                        $stmt = $this->conn()->query($sql);
                        while ($row4 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row4['id'] ?>"><?php echo $row4['program'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Room</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_room_id" name="room_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM room";
                        $stmt = $this->conn()->query($sql);
                        while ($row5 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row5['id'] ?>"><?php echo $row5['room'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Section</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_section_id" name="section_id" required>
                        <option value="">Select</option>
                        <?php $sql = "SELECT * FROM section";
                        $stmt = $this->conn()->query($sql);
                        while ($row6 = $stmt->fetch()) { ?>
                          <option value="<?php echo $row6['id'] ?>"><?php echo $row6['section'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Day</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_day" name="day" required>
                        <option value="">Select</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="project_list_id" class="col-sm-3 control-label">Time</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="edit_time" name="time" required>
                        <option value="">Select</option>
                        <option value="7:00 - 7:30 AM">7:00 - 7:30 AM</option>
                        <option value="7:30 - 8:00 AM">7:30 - 8:00 AM</option>
                        <option value="8:00 - 8:30 AM">8:00 - 8:30 AM</option>
                        <option value="8:30 - 9:00 AM">8:30 - 9:00 AM</option>
                        <option value="9:00 - 9:30 AM">9:00 - 9:30 AM</option>
                        <option value="9:30 - 10:00 AM">9:30 - 10:00 AM</option>
                        <option value="10:00 - 10:30 AM">10:00 - 10:30 AM</option>
                        <option value="10:30 - 11:00 AM">10:30 - 11:00 AM</option>
                        <option value="11:00 - 11:30 AM">11:00 - 11:30 AM</option>
                        <option value="11:30 - 12:00 PM">11:30 - 12:00 PM</option>
                        <option value="12:00 - 12:30 PM">12:00 - 12:30 PM</option>
                        <option value="12:30 - 1:00 PM">12:30 - 1:00 PM</option>
                        <option value="1:00 - 1:30 PM">1:00 - 1:30 PM</option>
                        <option value="1:30 - 2:00 PM">1:30 - 2:00 PM</option>
                        <option value="2:00 - 2:30 PM">2:00 - 2:30 PM</option>
                        <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                        <option value="3:00 - 3:30 PM">3:00 - 3:30 PM</option>
                        <option value="3:30 - 4:00 PM">3:30 - 4:00 PM</option>
                        <option value="4:00 - 4:30 PM">4:00 - 4:30 PM</option>
                        <option value="4:30 - 5:00 PM">4:30 - 5:00 PM</option>
                        <option value="5:00 - 5:30 PM">5:00 - 5:30 PM</option>
                        <option value="5:30 - 6:00 PM">5:30 - 6:00 PM</option>
                        <option value="6:00 - 6:30 PM">6:00 - 6:30 PM</option>
                        <option value="6:30 - 7:00 PM">6:30 - 7:00 PM</option>

                      </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-flat" name="edit" style="background-color: #E5EE7F;"><i class="fa fa-save"></i> Save</button>
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
              <form class="form-horizontal" method="POST" action="../controller/scheduleController.php">
                <input type="hidden" name="id" id="delete_id">
                <div class="text-center">
                    <p>DELETE SCHEDULE</p>
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

