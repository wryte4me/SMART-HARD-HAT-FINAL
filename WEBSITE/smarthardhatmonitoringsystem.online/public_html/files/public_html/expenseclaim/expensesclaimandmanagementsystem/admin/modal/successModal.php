
<div class="modal fade" id="success">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #eb6114;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/cedulaController.php">
                <div class="text-center">
                    <p>SAVED SUCCESSFULLY</p>
                    <h2 class="bold catname"></h2>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
              <button type="button" class="btn btn-flat" style="background-color: #eb6114;color: #fff;width: 100px;" data-dismiss="modal">OK</button>
              </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="error">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #751010;">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff;">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b></b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="../controller/cedulaController.php">
                <div class="text-center">
                    <p>DATA ALREADY EXIST</p>
                    <h2 class="bold catname"></h2>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
              <button type="button" class="btn btn-flat" style="background-color: #d35b5b;color: #fff;width: 100px;" data-dismiss="modal">OK</button>
              </form>
            </div>
        </div>
    </div>
</div>
