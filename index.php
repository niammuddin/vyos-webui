<?php
include 'header.php';
include 'sidebar.php';
?>
      <!-- page content -->
      <div id="app-content">

      <div class="app-content-area">

<div class="container-fluid">
    


    <div class="row">

            <div class="col-xl-6 col-md-12 col-12 mb-5">
                <div class="row row-cols-lg-2 row-cols-1 g-5">
                    <!-- Card 1 -->
                    <div class="col">
                        <div class="card h-100 card-lift">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semi-bold" id="type1">Connect</span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity text-gray-400">
                                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-4 mb-2">
                                <div class="mb-0">-> RIB: <span class="fw-bold" id="rib1"></span></div>
                                    <div class="mb-0">-> FIB: <span class="fw-bold" id="fib1"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col">
                        <div class="card h-100 card-lift">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semi-bold" id="type2">Static</span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart text-gray-400">
                                            <path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path>
                                            <path d="M22 12A10 10 0 0 0 12 2v10z"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-4 mb-2">
                                <div class="mb-0">-> RIB: <span class="fw-bold" id="rib2"></span></div>
                                    <div class="mb-0">-> FIB: <span class="fw-bold" id="fib2"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col">
                        <div class="card h-100 card-lift">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semi-bold" id="type3">eBGP</span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send text-gray-400">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-4 mb-2">
                                <div class="mb-0">-> RIB: <span class="fw-bold" id="rib3"></span></div>
                                    <div class="mb-0">-> FIB: <span class="fw-bold" id="fib3"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col">
                        <div class="card h-100 card-lift">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semi-bold" id="type4">iBGP</span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock text-gray-400">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-4 mb-2">
                                    <div class="mb-0">-> RIB: <span class="fw-bold" id="rib4"></span></div>
                                    <div class="mb-0">-> FIB: <span class="fw-bold" id="fib4"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-6 col-md-12 col-12 mb-5">
    <div class="card h-100">
        <div class="card-body">
            <div class="row row-cols-lg-3  my-8">
                <div class="col">
                    <div>
                        <h4 class="mb-3">Routes Total</h4>
                        <div class="lh-1">
                            <h4 class="fs-2 fw-bold text-info mb-0 "><span id="routesTotalPercentage"></span></h4>
                            <span class="text-secondary" id="routesTotalValue"></span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <h4 class="mb-3">Routes Total FIB</h4>
                        <div class="lh-1">
                            <h4 class="fs-2 fw-bold text-success mb-0 "><span id="routesTotalFibPercentage"></span></h4>
                            <span class="text-secondary" id="routesTotalFibValue"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 mb-3">
                <div class="progress" style="height: 40px;">
                    <div class="progress-bar bg-info" role="progressbar" aria-label="Segment one" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBarRoutesTotal"></div>
                    <div class="progress-bar bg-success" role="progressbar" aria-label="Segment two" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBarRoutesTotalFib"></div>
                </div>
            </div>
            <div>
                <small><span class="mdi mdi-lightbulb-outline me-1"></span>How perfformed over the last 30 days?</small>
            </div>
        </div>
    </div>
</div>



          </div>
  
    <div class="row  mb-5">
        <div class="col-12">
        <div class="card h-100">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Live Traffic</h4>
                <select id="interfaceDropdown" class="form-select w-auto">
                    <option value="" selected>Select Interface</option>
                </select>
            </div>

            <div class="card-body p-0">
            <div id="chart"></div>
            </div>

        </div>
        </div>
    </div>






</div>
</div>


</div>
<script src="./assets/apexcharts/dist/apexcharts.min.js"></script>
<script>

function fetchData() {

// IP_ROUTE_API_URL
    fetch('http://10.10.10.10:5000/ip_route?api_key=YOUR_API_KEY')
        .then(response => response.json())
        .then(data => {
  
            document.getElementById("rib1").textContent = data.routes[0].rib;
            document.getElementById("fib1").textContent = data.routes[0].fib;
            // document.getElementById("type1").textContent = data.routes[0].type;

            document.getElementById("rib2").textContent = data.routes[1].rib;
            document.getElementById("fib2").textContent = data.routes[1].fib;
            // document.getElementById("type2").textContent = data.routes[1].type;

            document.getElementById("rib3").textContent = data.routes[2].rib;
            document.getElementById("fib3").textContent = data.routes[2].fib;
            // document.getElementById("type3").textContent = data.routes[2].type;

            document.getElementById("rib4").textContent = data.routes[3].rib;
            document.getElementById("fib4").textContent = data.routes[3].fib;
            // document.getElementById("type4").textContent = data.routes[3].type;


            const totalRoutes = data.routesTotal + data.routesTotalFib;


            const routesTotalPercentage = (data.routesTotal / totalRoutes) * 100;
            const routesTotalFibPercentage = (data.routesTotalFib / totalRoutes) * 100;

            document.getElementById("routesTotalPercentage").textContent = `${routesTotalPercentage.toFixed(2)}%`;
            document.getElementById("routesTotalValue").textContent = `(${data.routesTotal})`;
            document.getElementById("routesTotalFibPercentage").textContent = `${routesTotalFibPercentage.toFixed(2)}%`;
            document.getElementById("routesTotalFibValue").textContent = `(${data.routesTotalFib})`;


            document.getElementById("progressBarRoutesTotal").style.width = `${routesTotalPercentage.toFixed(2)}%`;
            document.getElementById("progressBarRoutesTotalFib").style.width = `${routesTotalFibPercentage.toFixed(2)}%`;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

fetchData();


    </script>

<script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let receivedData = [];
            let sentData = [];
            const maxDataPoints = 60;
            let dropdown = document.getElementById("interfaceDropdown");
            let chart;

            function createChart() {
                chart = new ApexCharts(document.querySelector("#chart"), {
                    series: [
                        {
                            name: 'Received',
                            data: receivedData.slice(Math.max(receivedData.length - maxDataPoints, 0))
                        },
                        {
                            name: 'Sent',
                            data: sentData.slice(Math.max(sentData.length - maxDataPoints, 0))
                        }
                    ],
                    chart: {
                        height: 350,
                        type: 'area',
                        animations: {
                            enabled: true,
                            easing: 'linear',
                            dynamicAnimation: {
                                speed: 1000
                            }
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    xaxis: {
                        type: 'datetime',
                        categories: Array.from({ length: maxDataPoints }, (_, i) => new Date() - i * 1000),
                        labels: {
                            // show: false,
                            datetimeUTC: false
                        }
                    },
                    yaxis: {
                        title: {
                            show: false
                        },
                        tickAmount: 10
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                    curve: 'straight'
                    }
                });

                chart.render();
            }

            function fetchData(interface) {

                // BANDWIDTH_API_URL
                fetch(`http://10.10.10.10:5000/bandwidth?interface=${interface}&api_key=YOUR_API_KEY`)
                    .then(response => response.json())
                    .then(data => {
                        receivedData.push(data.received);
                        sentData.push(data.sent);

                        if (receivedData.length > maxDataPoints) {
                            receivedData.shift();
                            sentData.shift();
                        }

                        const receivedLastValue = receivedData[receivedData.length - 1];
                        const sentLastValue = sentData[sentData.length - 1];

                        chart.updateOptions({
                            xaxis: {
                                categories: Array.from({ length: maxDataPoints }, (_, i) => new Date() - (maxDataPoints - i) * 1000)
                            },
                            legend: {
                                show: true,
                                position: 'bottom',
                                horizontalAlign: 'center',
                                offsetY: 5,
                                formatter: function (seriesName) {
                                    if (seriesName === 'Received') {
                                        return `Received: <b>${receivedLastValue} Mbit/s</b>`;
                                    } else if (seriesName === 'Sent') {
                                        return `Sent: <b>${sentLastValue} Mbit/s</b>`;
                                    }
                                    return seriesName;
                                }
                            },
                            tooltip: {
                                x: {
                                    format: 'dd/MM/yy HH:mm:ss'
                                },
                                y: {
                                    formatter: function (value, { seriesIndex }) {
                                        if (seriesIndex === 0) {
                                            return `${value} Mbit/s`;
                                        } else if (seriesIndex === 1) {
                                            return `${value} Mbit/s`;
                                        }
                                        return value;
                                    }
                                }
                            }
                        });

                        chart.updateSeries([
                            {
                                name: 'Received',
                                data: receivedData.slice()
                            },
                            {
                                name: 'Sent',
                                data: sentData.slice()
                            }
                        ]);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });
            }

            function fetchInterfaces() {

                // INTERFACES_API_URL
                fetch('http://10.10.10.10:5000/interfaces?api_key=YOUR_API_KEY')
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(interface => {
                            let option = document.createElement("option");
                            option.text = interface;
                            option.value = interface;
                            dropdown.appendChild(option);
                        });
                    }).catch(err => {
                        console.error("Error fetching interfaces:", err);
                    });
            }

            fetchInterfaces();
            dropdown.addEventListener('change', () => {
                let selectedInterface = dropdown.value;
                if (selectedInterface === "") {
                    chart.updateSeries([]);
                    return;
                }
                fetchData(selectedInterface);
            });

            createChart();

            setInterval(() => {
                let selectedInterface = dropdown.value;
                if (selectedInterface) {
                    fetchData(selectedInterface);
                }
            }, 1000);
        });
    </script>

<?php include 'footer.php'; ?>