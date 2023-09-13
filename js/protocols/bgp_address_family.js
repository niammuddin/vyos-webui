$(document).ready(function() {
    let addressFamily = $('#address-family').DataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        ajax: {
            url: 'api/protocols/bgp.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'address-family'
            }
        },
        columns: [
            { data: 'asn' },
            {
                data: 'address_family',
                render: function(data) {
                  if (data === 'ipv6-unicast') {
                    return '<i class="badge badge-lg badge-dot bg-primary me-1"></i> ipv6';
                  } else if (data === 'ipv4-unicast') {
                    return '<i class="badge badge-lg badge-dot bg-info me-1"></i> ipv4';
                  }
                  return data;
                },
            },
            { data: 'network' },
            {
                data: null,
                render: function(data) {
                    let rowData = JSON.stringify(data);
                    rowData = rowData.replace(/"/g, "'");
                    return `<div class="dropdown dropstart">
                    <a class="btn btn-icon btn-ghost btn-xs rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" onclick="editStaticRoute(${rowData})">Edit</a></li>
                            <li><a class="dropdown-item" href="#" onclick="deleteStaticRoute(${rowData})">Delete</a></li>
                        </ul>
                        </div>
                    `;
                }
            }
        ]
    });
    new $.fn.dataTable.FixedHeader(addressFamily);
});