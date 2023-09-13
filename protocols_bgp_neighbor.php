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
                
                <!-- Page header -->
                <div class="justify-content-between align-items-center mb-4">
                  <div class="card h-100">

                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h4 class="mb-0">BGP Neighbor</h4>
                      <a href="#!" class="btn btn-primary btn-sm" onclick="addNeighbor()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</a>
                    </div>

                    <div class="card-body">
                      <div class="table-responsive table-card">
                          <table id="bgp-neighbor" class="table table-hover text-nowrap display table-centered mb-0"  style="width:100%">
                            <thead class="table-light">
                              <tr>
                                <th>Local AS</th>
                                <th>Neighbor IP</th>
                                <th>Remote AS</th>
                                <th>Address Family</th>
                                <th>Route Map Out</th>
                                <th>Route Map In</th>
                                <th>Description</th>
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

<script src="./js/protocols/bgp_neighbor.js?<?= time();?>"></script>

<?php
include 'footer.php';
?>