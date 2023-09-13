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
                  <button class="nav-link active fw-bold" id="nav-prefix-list-tab" data-bs-toggle="tab" data-bs-target="#nav-prefix-list" type="button" role="tab" aria-controls="nav-prefix-list" aria-selected="true">Prefix List</button>
                  <button class="nav-link fw-bold" id="nav-rule-tab" data-bs-toggle="tab" data-bs-target="#nav-rule" type="button" role="tab" aria-controls="nav-rule" aria-selected="false">Rule</button>
                </div>
              </nav>
            </div>

            <div class="card-body">
              <div class="tab-content mt-0">

                <div class="tab-pane fade show active" id="nav-prefix-list" role="tabpanel" aria-labelledby="nav-prefix-list-tab">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addShaper()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                  <div class="table-responsive">
                    <table id="prefix-list-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                      <thead class="table-light">
                        <tr>
                          <th>Name</th>
                          <th>Description</th>
                          <th></th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="nav-rule" role="tabpanel" aria-labelledby="nav-rule-tab">

                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addClass()">
                      <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>New</button>
                  </div>

                    <div class="table-responsive">
                        <table id="rule-table" class="table table-hover text-nowrap display table-centered mb-0" style="width:100%">
                        <thead class="table-light">
                            <tr>
                              <th>List Name</th>
                              <th>Rule</th>
                              <th>Action</th>
                              <th>Prefix</th>
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

<script src="./js/policy/prefix_list.js?<?= time();?>"></script>

<?php
include 'footer.php';
?>
