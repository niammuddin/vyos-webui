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
                  <button class="nav-link active fw-bold" id="nav-vlan-tab" data-bs-toggle="tab" data-bs-target="#nav-vlan" type="button" role="tab" aria-controls="nav-vlan" aria-selected="true">VLAN</button>
                  <button class="nav-link fw-bold" id="nav-vlan-address-tab" data-bs-toggle="tab" data-bs-target="#nav-vlan-address" type="button" role="tab" aria-controls="nav-vlan-address" aria-selected="false">IP Address</button>
                  <button class="nav-link fw-bold" id="nav-traffic-policy-tab" data-bs-toggle="tab" data-bs-target="#nav-traffic-policy" type="button" role="tab" aria-controls="nav-traffic-policy" aria-selected="false">Traffic Policy</button>
                  <button class="nav-link fw-bold" id="nav-redirect-tab" data-bs-toggle="tab" data-bs-target="#nav-redirect" type="button" role="tab" aria-controls="nav-redirect" aria-selected="false">Redirect</button>
                </div>
              </nav>
            </div>

            <div class="card-body">
              <div class="tab-content mt-0">

                <div class="tab-pane fade show active" id="nav-vlan" role="tabpanel" aria-labelledby="nav-vlan-tab">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addVLAN()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                  <div class="table-responsive">
                    <table id="vlan-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                      <thead class="table-light">
                        <tr>
                          <th>VLAN</th>
                          <th>Interfaces</th>
                          <th>Interfaces Type</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="nav-vlan-address" role="tabpanel" aria-labelledby="nav-vlan-address-tab">

                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addVlanAddress()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                    <div class="table-responsive">
                        <table id="address-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                        <thead class="table-light">
                            <tr>
                              <th>Address</th>
                              <th>Interfaces</th>
                              <th>Interfaces Type</th>
                              <th>Action</th>
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
                              <th>VLAN</th>
                              <th>Traffic Policy IN</th>
                              <th>Traffic Policy OUT</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-redirect" role="tabpanel" aria-labelledby="nav-redirect-tab">

                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addRedirect()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                    <div class="table-responsive">
                        <table id="redirect-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                        <thead class="table-light">
                            <tr>
                              <th>VLAN</th>
                              <th>Redirect IFB</th>
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
<script src="./js/interfaces/vlan.js?<?= time();?>"></script>
<?php
include 'footer.php';
?>
