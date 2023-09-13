      <!-- navbar vertical -->
      <!-- Sidebar -->
      <div class="navbar-vertical navbar nav-dashboard">
        <div class="h-100" data-simplebar="init">
          <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                  <div class="simplebar-content" style="padding: 0px;">
                    <!-- Brand logo -->
                    <div class="navbar-brand" href="/">
                      <img src="./assets/images/svg/vyos.svg">
                      <span class="icon-text text-dark">Localhost</span>
                    </div>
                    <!-- Navbar nav -->
                    <ul class="navbar-nav flex-column" id="sideNavbar">
                      <!-- Nav item -->
                      <li class="nav-item">
                        <a class="nav-link" href="/index.php">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z" />
                            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z" />
                          </svg> Dashboard </a>
                      </li>
                      <!-- Nav item -->
                      <li class="nav-item mt-3">
                        <div class="navbar-heading">Config</div>
                      </li>
                      <!-- Nav item -->
                      <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed" href="#!" data-bs-toggle="collapse" data-bs-target="#navinterfaces" aria-expanded="false" aria-controls="navinterfaces">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M4.5 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zM3 4.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1a2 2 0 0 1-2 2H8.5v3a1.5 1.5 0 0 1 1.5 1.5h5.5a.5.5 0 0 1 0 1H10A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5H.5a.5.5 0 0 1 0-1H6A1.5 1.5 0 0 1 7.5 10V7H2a2 2 0 0 1-2-2V4zm1 0v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1zm6 7.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5z" />
                          </svg> Interfaces </a>
                        <div id="navinterfaces" class="collapse" data-bs-parent="#sideNavbar">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./interfaces_bonding.php"> Bonding </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./interfaces_ethernet.php"> Ethernet </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./interfaces_bridge.php"> Bridge &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./interfaces_tunnel.php"> Tunnel &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a title="Input Functional Block" class="nav-link has-arrow" href="./interfaces_ifb.php"> IFB </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./interfaces_vlan.php"> VLAN </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed" href="#!" data-bs-toggle="collapse" data-bs-target="#nav-nat" aria-expanded="false" aria-controls="navpolicy">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z" />
                          </svg> NAT </a>
                        <div id="nav-nat" class="collapse" data-bs-parent="#sideNavbar">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./nat_destination.php"> Destination &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./nat_source.php"> Source &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./nat_nptv6.php"> NPTv6 &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <!-- Nav item -->
                      <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed" href="#!" data-bs-toggle="collapse" data-bs-target="#navpolicy" aria-expanded="false" aria-controls="navpolicy">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                            <path d="M8 4.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V9a.5.5 0 0 1-1 0V7.5H6a.5.5 0 0 1 0-1h1.5V5a.5.5 0 0 1 .5-.5z" />
                          </svg> Policy </a>
                        <div id="navpolicy" class="collapse" data-bs-parent="#sideNavbar">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./policy_aspath_list.php"> asPath list </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./policy_prefix_list.php"> Prefix List </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./policy_routemap.php"> Route Map </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <!-- Nav item -->
                      <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navProtocols" aria-expanded="false" aria-controls="navProtocols">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 3.5A.5.5 0 0 1 .5 3H1c2.202 0 3.827 1.24 4.874 2.418.49.552.865 1.102 1.126 1.532.26-.43.636-.98 1.126-1.532C9.173 4.24 10.798 3 13 3v1c-1.798 0-3.173 1.01-4.126 2.082A9.624 9.624 0 0 0 7.556 8a9.624 9.624 0 0 0 1.317 1.918C9.828 10.99 11.204 12 13 12v1c-2.202 0-3.827-1.24-4.874-2.418A10.595 10.595 0 0 1 7 9.05c-.26.43-.636.98-1.126 1.532C4.827 11.76 3.202 13 1 13H.5a.5.5 0 0 1 0-1H1c1.798 0 3.173-1.01 4.126-2.082A9.624 9.624 0 0 0 6.444 8a9.624 9.624 0 0 0-1.317-1.918C4.172 5.01 2.796 4 1 4H.5a.5.5 0 0 1-.5-.5z" />
                            <path d="M13 5.466V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192zm0 9v-3.932a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192z" />
                          </svg> Protocols </a>
                        <div id="navProtocols" class="collapse " data-bs-parent="#sideNavbar">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link has-arrow " href="#!" data-bs-toggle="collapse" data-bs-target="#navProtocolsBGP" aria-expanded="false" aria-controls="navProtocolsBGP"> BGP </a>
                              <div id="navProtocolsBGP" class="collapse" data-bs-parent="#navMenuLevel">
                                <ul class="nav flex-column">
                                  <li class="nav-item">
                                    <a class="nav-link " href="./protocols_bgp_parameters.php"> Parameters</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link " href="./protocols_bgp_address_family.php"> Address Family</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link " href="./protocols_bgp_neighbor.php"> Neighbor</a>
                                  </li>
                                </ul>
                              </div>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="./protocols_static_route.php"> Static Route </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed" href="#!" data-bs-toggle="collapse" data-bs-target="#nav-service" aria-expanded="false" aria-controls="nav-service">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z" />
                          </svg> Service </a>
                        <div id="nav-service" class="collapse" data-bs-parent="#sideNavbar">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./service_ssh.php"> SSH &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed" href="#!" data-bs-toggle="collapse" data-bs-target="#nav-system" aria-expanded="false" aria-controls="nav-system">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M5 0a.5.5 0 0 1 .5.5V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2h1V.5a.5.5 0 0 1 1 0V2A2.5 2.5 0 0 1 14 4.5h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14v1h1.5a.5.5 0 0 1 0 1H14a2.5 2.5 0 0 1-2.5 2.5v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14h-1v1.5a.5.5 0 0 1-1 0V14A2.5 2.5 0 0 1 2 11.5H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2v-1H.5a.5.5 0 0 1 0-1H2A2.5 2.5 0 0 1 4.5 2V.5A.5.5 0 0 1 5 0zm-.5 3A1.5 1.5 0 0 0 3 4.5v7A1.5 1.5 0 0 0 4.5 13h7a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 11.5 3h-7zM5 6.5A1.5 1.5 0 0 1 6.5 5h3A1.5 1.5 0 0 1 11 6.5v3A1.5 1.5 0 0 1 9.5 11h-3A1.5 1.5 0 0 1 5 9.5v-3zM6.5 6a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z" />
                          </svg> System </a>
                        <div id="nav-system" class="collapse" data-bs-parent="#sideNavbar">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./system_conntrack.php"> Conntrack &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <!-- Nav item -->
                      <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navTrafficPolicy" aria-expanded="false" aria-controls="navTrafficPolicy">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z" />
                          </svg> Traffic Policy </a>
                        <div id="navTrafficPolicy" class="collapse " data-bs-parent="#sideNavbar">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link" href="./traffic_policy_shaper.php"> Shaper </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="./traffic_policy_limiter.php"> Limiter &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link has-arrow  collapsed" href="#!" data-bs-toggle="collapse" data-bs-target="#nav-vpn" aria-expanded="false" aria-controls="nav-vpn">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                            <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                          </svg> VPN </a>
                        <div id="nav-vpn" class="collapse" data-bs-parent="#sideNavbar">
                          <ul class="nav flex-column">
                            <li class="nav-item">
                              <a class="nav-link has-arrow" href="./vpn_l2tp.php"> L2TP &nbsp; <span class="badge bg-primary">coming soon</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 1497px;"></div>
          </div>
          <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
          </div>
          <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="height: 372px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
          </div>
        </div>
      </div>
      <script>
        document.addEventListener("DOMContentLoaded", (function() {
          let t = window.location.pathname.split("/").pop();
          document.querySelectorAll("#sideNavbar a.nav-link").forEach((function(e) {
            if (e.getAttribute("href").split("/").pop() === t) {
              e.classList.add("active");
              let t = e.parentElement;
              for (; t;) t.classList.contains("collapse") && t.classList.add("show"), t = t.parentElement
            }
          }))
        }));
      </script>