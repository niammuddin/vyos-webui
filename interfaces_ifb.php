<?php
include 'header.php';
include 'sidebar.php';
?>

<!-- page content -->
<div id="app-content">
  <div class="app-content-area">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
          <div class="card h-100">
            <div class="card-header border-0">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active fw-bold" id="nav-ifb-tab" data-bs-toggle="tab" data-bs-target="#nav-ifb" type="button" role="tab" aria-controls="nav-ifb" aria-selected="true">IFB</button>
                  <button class="nav-link fw-bold" id="nav-traffic-policy-tab" data-bs-toggle="tab" data-bs-target="#nav-traffic-policy" type="button" role="tab" aria-controls="nav-traffic-policy" aria-selected="false">Traffic Policy</button>
                </div>
              </nav>
            </div>

            <div class="card-body">
              <div class="tab-content mt-0">

                <div class="tab-pane fade show active" id="nav-ifb" role="tabpanel" aria-labelledby="nav-ifb-tab">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addIFB()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                  <div class="table-responsive">
                    <table id="ifb-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                      <thead class="table-light">
                        <tr>
                          <th>IFB</th>
                          <th>Description</th>
                          <th></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="nav-traffic-policy" role="tabpanel" aria-labelledby="nav-traffic-policy-tab">

                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addTrafficPolicy()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                    <div class="table-responsive">
                        <table id="traffic-policy-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                        <thead class="table-light">
                            <tr>
                              <th>IFB</th>
                              <th>Traffic Policy IN</th>
                              <th>Traffic Policy OUT</th>
                              <th></th>
                            </tr>
                        </thead>
                        </table>
                    </div>
                </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="./js/interfaces/ifb.js?<?= time();?>"></script>


<?php
include 'footer.php';
?>
