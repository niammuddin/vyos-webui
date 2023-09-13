$(document).ready(function() {
    let neighbor = $('#bgp-neighbor').DataTable({
    // aLengthMenu: [[5, 25, 50, 100, -1], [5, 25, 50, 100, "All"]],
    // iDisplayLength: 5,
    processing: true,
    responsive: true,
    serverSide: false,
    ajax: {
      url: 'api/protocols/bgp.php',
      type: 'POST',
      data: {
        action: 'neighbor'
    }
    },
    columns: [
      { data: 'bgpKey' },
      { data: 'neighborIP' },
      { data: 'remoteAs' },
      {
        data: 'addressFamily',
        render: function(data) {
          if (data === 'ipv6-unicast') {
            return '<i class="badge badge-lg badge-dot bg-primary me-1"></i> ipv6';
          } else if (data === 'ipv4-unicast') {
            return '<i class="badge badge-lg badge-dot bg-info me-1"></i> ipv4';
          }
          return data;
        },
      },
      { data: 'routeMapExport' },
      { data: 'routeMapImport' },
      { data: 'description' },
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
                    <li><a class="dropdown-item" href="#" onclick="editNeighbor(${rowData})">Edit</a></li>
                    <li><a class="dropdown-item" href="#" onclick="deleteNeighbor(${rowData})">Delete</a></li>
                </ul>
                </div>
            `;
        }
    }
    ],
  });
  new $.fn.dataTable.FixedHeader( neighbor );
  });
function addNeighbor() {
Swal.fire({
    title: 'Add BGP Neighbor',
    html: `
    <form id="addForm">
        <div class="form-group">
            <input type="text" id="bgpKey" class="form-control" placeholder="Local AS">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="neighborIP" class="form-control" placeholder="Neighbor IP">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="description" class="form-control" placeholder="Description">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="remoteAs" class="form-control" placeholder="Remote AS">
        </div>
        <br/>
        <div class="form-group">
            <select id="addressFamily" class="form-select">
                <option value="" disabled selected>Choose Address-Family</option>
                <option value="ipv4-unicast">IPv4 Unicast</option>
                <option value="ipv6-unicast">IPv6 Unicast</option>
            </select>
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="routeMapExport" class="form-control" placeholder="Route Map Export">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="routeMapImport" class="form-control" placeholder="Route Map Import">
        </div>
    </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Save',
    cancelButtonText: 'Cancel',
    showLoaderOnConfirm: true,
    focusConfirm: false,
    allowOutsideClick: false,
    preConfirm: function () {
        // Ambil nilai-nilai dari input form untuk tambah BGP Neighbor
        const bgpKey = $('#bgpKey').val();
        const neighborIP = $('#neighborIP').val();
        const description = $('#description').val();
        const remoteAs = $('#remoteAs').val();
        const addressFamily = $('#addressFamily').val();
        const routeMapExport = $('#routeMapExport').val();
        const routeMapImport = $('#routeMapImport').val();

        // Kirim permintaan AJAX untuk tambah BGP Neighbor dengan metode POST
        return $.ajax({
            url: 'api/protocols/bgp.php', // Ganti dengan URL endpoint API yang sesuai
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'add-neighbor',
                bgpKey: bgpKey,
                neighborIP: neighborIP,
                description: description,
                remoteAs: remoteAs,
                addressFamily: addressFamily,
                routeMapExport: routeMapExport,
                routeMapImport: routeMapImport
            }
        });
    }
}).then(function (result) {
    if (result.isConfirmed) {
        if (result.value.success) {
            Swal.fire('Success!', 'New BGP Neighbor has been added.', 'success');
            // Refresh tabel setelah berhasil tambah data
            $('#bgp-neighbor').DataTable().ajax.reload();
        } else {
            Swal.fire('Error!', result.value.message, 'error');
        }
    }
}).catch(function (error) {
    Swal.fire('Error!', 'Failed to add BGP Neighbor.', 'error');
    console.error('Failed to add BGP Neighbor:', error);
});
}
function editNeighbor(data) {

let originalDescription = data.description;
let originalRemoteAs = data.remoteAs;
let originalRouteMapExport = data.routeMapExport;
let originalRouteMapImport = data.routeMapImport;

Swal.fire({
    title: 'Edit BGP Neighbor',
    html: `
    <form id="editForm">
        <div class="form-group">
            <input type="text" id="bgpKey" class="form-control" value="${data.bgpKey}" disabled>
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="neighborIP" class="form-control" value="${data.neighborIP}" disabled>
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="addressFamily" class="form-control" value="${data.addressFamily}" disabled>
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="remoteAs" class="form-control" value="${data.remoteAs}" placeholder="Remote AS" disabled>
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="routeMapExport" class="form-control" value="${data.routeMapExport}" placeholder="Route Map Export">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="routeMapImport" class="form-control" value="${data.routeMapImport}" placeholder="Route Map Import">
        </div>
        <br/>
        <div class="form-group">
            <input type="text" id="description" class="form-control" value="${data.description}" placeholder="Description">
        </div>
    </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Save',
    cancelButtonText: 'Cancel',
    showLoaderOnConfirm: true,
    focusConfirm: false,
    allowOutsideClick: false,
    preConfirm: function() {

    const newDescription = $('#description').val();
    const newRemoteAs = $('#remoteAs').val();
    const newRouteMapExport = $('#routeMapExport').val();
    const newRouteMapImport = $('#routeMapImport').val();

    if (
        newDescription === originalDescription &&
        newRemoteAs === originalRemoteAs &&
        newRouteMapExport === originalRouteMapExport &&
        newRouteMapImport === originalRouteMapImport
    ) {
        Swal.fire('No Changes!', 'There are no changes in BGP Neighbor data.', 'warning');
        return false;
    } else {
        return $.ajax({
        url: 'api/protocols/bgp.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'edit-neighbor',
            bgpKey: data.bgpKey,
            neighborIP: data.neighborIP,
            addressFamily: data.addressFamily,
            remoteAs: data.remoteAs,
            routeMapExport: newRouteMapExport,
            routeMapImport: newRouteMapImport,
            description: newDescription
        }
        }).then(function(result) {
        return result;
        });
    }
    }
}).then(function(result) {
    if (result.isConfirmed) {
    if (result.value && result.value.success) {
        Swal.fire('Success!', 'BGP Neighbor data has been updated.', 'success');
        $('#bgp-neighbor').DataTable().ajax.reload();
    } else {
        Swal.fire('Error!', result.value.message, 'error');
    }
    }
}).catch(function(error) {
    Swal.fire('Error!', 'Failed to update BGP Neighbor data.', 'error');
    console.error('Failed to update BGP Neighbor data:', error);
});
}
function deleteNeighbor(data) {
Swal.fire({
    title: "Delete BGP Neighbor",
    html: `Are you sure you want to delete BGP Neighbor?<br><br><small><b> ${data.neighborIP} </b></small>`,
    icon: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonText: "Delete",
    preConfirm: function () {
        return $.ajax({
            url: 'api/protocols/bgp.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'delete-neighbor',
                bgpKey: data.bgpKey,
                neighborIP: data.neighborIP
            }
        });
    },
    backdrop: true,
    allowOutsideClick: true
}).then(function (result) {
    if (result.isConfirmed) {
        if (result.value.success) {
            Swal.fire('Deleted!', 'BGP Neighbor has been deleted.', 'success');
            $('#bgp-neighbor').DataTable().ajax.reload();
        } else {
            Swal.fire('Error!', result.value.message, 'error');
        }
    }
}).catch(function (error) {
    Swal.fire('Error!', 'Failed to delete BGP Neighbor.', 'error');
    console.error('Failed to delete BGP Neighbor:', error);
});
}