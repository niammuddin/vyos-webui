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
                  <button class="nav-link active fw-bold" id="nav-shaper-tab" data-bs-toggle="tab" data-bs-target="#nav-shaper" type="button" role="tab" aria-controls="nav-shaper" aria-selected="true">Shaper</button>
                  <button class="nav-link fw-bold" id="nav-shaper-class-tab" data-bs-toggle="tab" data-bs-target="#nav-shaper-class" type="button" role="tab" aria-controls="nav-shaper-class" aria-selected="false">Class</button>
                  <button class="nav-link fw-bold" id="nav-shaper-class-match-tab" data-bs-toggle="tab" data-bs-target="#nav-shaper-class-match" type="button" role="tab" aria-controls="nav-shaper-class-match" aria-selected="false">Match</button>
                </div>
              </nav>
            </div>

            <div class="card-body">
              <div class="tab-content mt-0">

                <div class="tab-pane fade show active" id="nav-shaper" role="tabpanel" aria-labelledby="nav-shaper-tab">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addShaper()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                  <div class="table-responsive">
                    <table id="shaper-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                      <thead class="table-light">
                        <tr>
                          <th>Shaper</th>
                          <th>Bandwidth</th>
                          <th>Default Bandwidth</th>
                          <th>Default Burst</th>
                          <th>Default Queue Type</th>
                          <th>Description</th>
                          <th></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="nav-shaper-class" role="tabpanel" aria-labelledby="nav-shaper-class-tab">

                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addClass()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                    <div class="table-responsive">
                        <table id="class-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                        <thead class="table-light">
                            <tr>
                              <th>Shaper</th>
                              <th>Class</th>
                              <th>Match</th>
                              <th>Bandwidth</th>
                              <th>Burst</th>
                              <th>Queue Type</th>
                              <th>Description</th>
                              <th></th>
                            </tr>
                        </thead>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-shaper-class-match" role="tabpanel" aria-labelledby="nav-shaper-class-match-tab">

                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addMatch()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                    <div class="table-responsive">
                        <table id="match-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                        <thead class="table-light">
                            <tr>
                              <th>Shaper</th>
                              <th>Class</th>
                              <th>Match</th>
                              <th>Interface</th>
                              <th>Dst-IP</th>
                              <th>Src-IP</th>
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

<script src="./js/traffic-policy/shaper.js?<?= time();?>"></script>

<?php
include 'footer.php';
?>
