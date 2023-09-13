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
                  <button class="nav-link active fw-bold" id="nav-bonding-tab" data-bs-toggle="tab" data-bs-target="#nav-bonding" type="button" role="tab" aria-controls="nav-bonding" aria-selected="true">Bonding</button>
                  <button class="nav-link fw-bold" id="nav-bond-address-tab" data-bs-toggle="tab" data-bs-target="#nav-bond-address" type="button" role="tab" aria-controls="nav-bond-address" aria-selected="false">IP Address</button>
                </div>
              </nav>
            </div>

            <div class="card-body">
              <div class="tab-content mt-0">
                <div class="tab-pane fade show active" id="nav-bonding" role="tabpanel" aria-labelledby="nav-bonding-tab">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addBonding()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                  <div class="table-responsive">
                    <table id="interfaces-bonding" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                      <thead class="table-light">
                        <tr>
                          <th>Name</th>
                          <th>Mode</th>
                          <th>Hash Policy</th>
                          <th>Member Interfaces</th>
                          <th>Num VLAN</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="nav-bond-address" role="tabpanel" aria-labelledby="nav-bond-address-tab">

                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addAddress()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                  <div class="table-responsive">
                    <table id="bonding-address" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                    <thead class="table-light">
                        <tr>
                          <th>Interfaces</th>
                          <th>Address</th>
                          <th>Action</th>
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

<script src="./js/interfaces/bonding.js?<?= time();?>"></script>

<?php
include 'footer.php';
?>
