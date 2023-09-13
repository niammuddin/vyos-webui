$(document).ready(function() {

    let nextHopColors = JSON.parse(localStorage.getItem('nextHopColors')) || {};
    
    let staticRoute = $('#static-route').DataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        ajax: {
            url: 'api/protocols/static_route.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'static-route'
            }
        },
        columns: [
            { data: 'prefix' },
            {
                data: null,
                render: function(data, type, row) {
                    let nextHop = row['nextHop'];
                    let nextHopColor = getColorForNextHop(nextHop, nextHopColors);
                    return `<i class="badge badge-lg badge-dot me-1" style="background-color: ${nextHopColor};"></i> ${nextHop}`;
                }
            },
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
    new $.fn.dataTable.FixedHeader( staticRoute );

    function getColorForNextHop(nextHop, nextHopColors) {
        if (!nextHopColors[nextHop]) {
            let color = '#' + Math.floor(Math.random() * 16777215).toString(16);
            nextHopColors[nextHop] = color;
            localStorage.setItem('nextHopColors', JSON.stringify(nextHopColors));
        }
        return nextHopColors[nextHop];
    }
});

function addStaticRoute() {
    Swal.fire({
        title: 'Add Static Route',
        html: `
        <form id="addForm">
            <div class="form-group">
            <input type="text" id="prefix" class="mt-3 form-control" placeholder="192.168.1.0/24">
            <input type="text" id="nextHop" class="mt-3 form-control" placeholder="10.10.10.1">
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

            const prefix = $('#prefix').val();
            const nextHop = $('#nextHop').val();

            // Validasi form sebelum mengirim permintaan AJAX
            if (!prefix || !nextHop) {
                Swal.showValidationMessage('All fields are required!');
                return false;
            }

            return $.ajax({
                url: 'api/protocols/static_route.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'add-static-route',
                    prefix: prefix,
                    nextHop: nextHop
                }
            });
        }
    }).then(function(result) {
        if (result.isConfirmed) {
            if (result.value.success) {
                Swal.fire('Success!', 'Static Route has been added.', 'success');

                console.log('Debug Success:', result);
                $('#static-route').DataTable().ajax.reload();
            } else {
                Swal.fire('Error!', result.value.message, 'error');
                console.log('Debug Error:', result);
            }
        }
    }).catch(function(error) {
        Swal.fire('Error!', 'Failed to add Static Route data.', 'error');
        console.error('Failed to add Static Route data:', error);
    });
}
function deleteStaticRoute(data) {
	Swal.fire({
		title: "Delete Static Route",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">Prefix -> ${data.prefix}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/protocols/static_route.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'delete-static-route',
					prefix: data.prefix,
					nextHop: data.nextHop
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'Static Route has been deleted.', 'success');
				$('#static-route').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete Static Route.', 'error');
		console.error('Failed to delete Static Route:', error);
	});
}