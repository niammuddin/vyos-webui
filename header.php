<?php 
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
  <head>
    <title>vyOS API</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/images/icon/vyos-icon.png">
    <!-- Js jquery -->
    <script src="./assets/js/jquery.min.js"></script>
    <!-- dataTables -->
    <link rel="stylesheet" type="text/css" href="./assets/DataTables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/DataTables/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/DataTables/responsive.bootstrap5.min.css">
    <script src="./assets/DataTables/jquery.dataTables.min.js"></script>
    <script src="./assets/DataTables/dataTables.bootstrap5.min.js"></script>
    <script src="./assets/DataTables/dataTables.fixedHeader.min.js"></script>
    <script src="./assets/DataTables/dataTables.responsive.min.js"></script>
    <script src="./assets/DataTables/responsive.bootstrap.min.js"></script>
    <!-- Js bootstrap -->
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <!-- Libs CSS -->
    <link rel="stylesheet" type="text/css" href="./assets/css/simplebar.min.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="./assets/css/theme.min.css">
    <!-- sweetalert2 -->
    <script src="./assets/sweetalert2@11.0.19/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./assets/sweetalert2@11.0.19/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/apexcharts/dist/apexcharts.css">
    <style>
      .app-content-area {
        font-size: small;
      }
      .badge-dot {
        align-items: center;
        background: transparent;
        display: inline-flex;
      }

      .badge-dot i {
        border-radius: 50%;
        display: inline-block;
        vertical-align: middle
      }

      .badge-dot.badge-md i {
        height: .5rem;
        width: .5rem
      }

      .badge-dot.badge-lg i {
        height: .625rem;
        width: .625rem
      }

      .swal2-popup,
      .swal2-popup input {
        font-size: small;
      }

      .swal2-popup select,
      .swal2-popup option {
        font-size: small;
        color: #525f7f
      }

      .btn-bg-custom {
        background-color: #7367f0;
        color: #fff
      }

      .btn-bg-custom:hover {
        background-color: #624bff;
        color: #fff
      }

      .icon-text {
        font-weight: bold;
        padding-left: 5px;
      }

      .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-size: 10px !important;
      }
      .card .apexcharts-tooltip-title {
          font-weight: normal !important;
          font-size: smaller !important;
      }

      @font-face {
        font-family: "bootstrap-icons";
        src: url("./assets/css/bootstrap-icons-1.3.0/fonts/bootstrap-icons.woff?4601c71fb26c9277391ec80789bfde9c") format("woff");
      }
    </style>
  </head>
  <body>
    <main id="main-wrapper" class="main-wrapper">
      <div class="header">
        <!-- navbar -->
        <div class="navbar-custom navbar navbar-expand-lg">
          <div class="container-fluid px-0">
            <a class="navbar-brand d-block d-md-none" href="#">
              <img src="./assets/images/svg/vyos-mobile.svg" alt="Logo Image">
            </a>
            <a id="nav-toggle" href="#!" class="ms-auto ms-md-0 me-0 me-lg-3 ">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-text-indent-left text-muted" viewBox="0 0 16 16">
                <path d="M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm.646 2.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8 2.646 6.354a.5.5 0 0 1 0-.708zM7 6.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm-5 3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
              </svg>
            </a>
            <div class="d-none d-md-none d-lg-block">
              <!-- Form -->
              <form action="#">
                <div class="input-group ">
                  <input class="form-control rounded-3" type="search" value="" id="searchInput" placeholder="Search">
                  <span class="input-group-append">
                    <button class="btn  ms-n10 rounded-0 rounded-end" type="button">
                      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search text-dark">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                      </svg>
                    </button>
                  </span>
                </div>
              </form>
            </div>
            <!--Navbar nav -->
            <ul class="navbar-nav navbar-right-wrap ms-lg-auto d-flex nav-top-wrap align-items-center ms-4 ms-lg-0">
              <a href="pages/starter.html#" class="form-check form-switch theme-switch btn btn-ghost btn-icon rounded-circle mb-0 ">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault"></label>
              </a>
              <li class="dropdown stopevent ms-2">
                <a class="btn btn-ghost btn-icon rounded-circle" href="pages/starter.html#!" role="button" id="dropdownNotification" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell icon-xs">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                  </svg>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="dropdownNotification">
                  <div>
                    <div class="border-bottom px-3 pt-2 pb-3 d-flex
              justify-content-between align-items-center">
                      <p class="mb-0 text-dark fw-medium fs-4">Notifications</p>
                      <a href="pages/starter.html#!" class="text-muted">
                        <span>
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings me-1 icon-xs">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                          </svg>
                        </span>
                      </a>
                    </div>
                    <div data-simplebar="init" style="height: 250px;">
                      <div class="simplebar-wrapper" style="margin: 0px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                          <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask">
                          <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                              <div class="simplebar-content" style="padding: 0px;">
                                <!-- List group -->
                                <ul class="list-group list-group-flush notification-list-scroll"></ul>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                      </div>
                      <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                      </div>
                      <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                      </div>
                    </div>
                    <div class="border-top px-3 py-2 text-center">
                      <a href="pages/starter.html#!" class="text-inherit "> View all Notifications </a>
                    </div>
                  </div>
                </div>
              </li>
              <!-- List -->
              <li class="dropdown ms-2">
                <a class="rounded-circle" href="pages/starter.html#!" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="avatar avatar-md avatar-indicators avatar-online">
                    <img alt="avatar" src="./assets/images/avatar.jpeg" class="rounded-circle">
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                  <div class="px-4 pb-0 pt-2">
                    <div class="lh-1 ">
                      <h5 class="mb-1"> John E. Grainger</h5>
                      <a href="#" class="text-inherit fs-6">View my profile</a>
                    </div>
                    <div class=" dropdown-divider mt-3 mb-2"></div>
                  </div>
                  <ul class="list-unstyled">
                    <li>
                      <a class="dropdown-item d-flex align-items-center" href="pages/starter.html#!">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user me-2 icon-xxs dropdown-item-icon">
                          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                          <circle cx="12" cy="7" r="4"></circle>
                        </svg>Edit Profile </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages/starter.html#!">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity me-2 icon-xxs dropdown-item-icon">
                          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>Activity Log </a>
                    </li>
                    <li>
                      <a class="dropdown-item d-flex align-items-center" href="pages/starter.html#!">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings me-2 icon-xxs dropdown-item-icon">
                          <circle cx="12" cy="12" r="3"></circle>
                          <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>Settings </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="/logout.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power me-2 icon-xxs dropdown-item-icon">
                          <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                          <line x1="12" y1="2" x2="12" y2="12"></line>
                        </svg>Sign Out </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>