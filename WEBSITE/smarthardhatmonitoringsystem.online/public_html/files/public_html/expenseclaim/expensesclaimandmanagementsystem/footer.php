<div class="modal fade" id="error">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #751010;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b></b></h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <p>INVALID CREDENTIALS</p>
                    <h2 class="bold catname"></h2>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
              <button type="button" class="btn btn-flat" style="background-color: #d35b5b;color: #fff;width: 100px;" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>


<script>
  <?php if (isset($_SESSION['error'])) { ?>
    $('#error').modal('show')
  <?php unset($_SESSION['error']); } ?>
</script>