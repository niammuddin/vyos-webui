$(document).ready(function() {
  let loadedData = {};

  function loadDataTable(tabId) {
    if (tabId === 'ethernet' && !loadedData[tabId]) {
      initEthernet();
      loadedData[tabId] = true;
    } else if (tabId === 'address' && !loadedData[tabId]) {
      iniAddress();
      loadedData[tabId] = true;
    }
  }

function initEthernet() {
  var ethernet = $('#interfaces-ethernet').DataTable({
  processing: true,
  responsive: true,
  serverSide: false,
  ajax: {
    url: 'api/interfaces/ethernet.php',
    type: 'POST',
    dataType: 'json',
    data: {
      action: 'ethernet-table'
    }
  },
  columns: [
    { data: 'ethernetName' },
    { data: 'description' },
    { data: 'ethernet_mac' },
    { data: 'numvif' },
    {
      data: null,
      render: function(data) {
          let rowData = JSON.stringify(data);
          return `<div class="dropdown dropstart">
          <a class="btn btn-icon btn-ghost btn-xs rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#" onclick='editEthernet(${rowData})'>Edit</a></li>
          </ul>
        </div>`;
      }
  }
  ],
});
new $.fn.dataTable.FixedHeader( ethernet );
}

function iniAddress() {
  // ethernet ip address
  var ethernetAddress = $('#ethernet-address').DataTable({
    processing: true,
    responsive: true,
    serverSide: false,
    ajax: {
      url: 'api/interfaces/ethernet.php',
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'address-table'
      }
    },
    columns: [
      { data: 'ethernetName' },
      { data: 'address' },
      {
        data: null,
        render: function(data) {
            let rowData = JSON.stringify(data);
            return `<div class="dropdown dropstart">
            <a class="btn btn-icon btn-ghost btn-xs rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
              <li><a class="dropdown-item" href="#" onclick='deleteAddress(${rowData})'>Delete</a></li>
            </ul>
          </div>`;
        }
    }
    ],
  });
  new $.fn.dataTable.FixedHeader( ethernetAddress );
}

initEthernet();
loadedData['ethernet'] = true;
$(".nav-link").on("shown.bs.tab", function(e) {
  let targetTabId = $(e.target).attr("aria-controls");
  if (targetTabId === 'nav-ethernet') {
    loadDataTable('ethernet');
  } else if (targetTabId === 'nav-address') {
    loadDataTable('address');
  }
});
});
  
// edit ethernet
function editEthernet(data) {
	Swal.fire({
	  title: 'Edit Ethernet',
	  html: `
		<form id="editForm">
		<div class="form-group">
		  <input type="text" id="description" class="mt-3 form-control" value="${data.description}" placeholder="description">
		</div>
		</form>
		`,
	  showCancelButton: true,
	  confirmButtonText: 'Save',
	  cancelButtonText: 'Cancel',
	  showLoaderOnConfirm: true,
	  focusConfirm: true,
	  allowOutsideClick: false,
	  preConfirm: function () {

		const ethernetName = data.ethernetName;
    const description = $('#description').val();

        if (
			description === data.description
        ) {
          Swal.fire('No Changes', 'There are no changes to save.', 'info');
          return false;
          }
  
		return $.ajax({
		  url: 'api/interfaces/ethernet.php',
		  type: 'POST',
		  dataType: 'json',
		  data: {
			action: 'edit-ethernet',
			ethernetName: ethernetName,
			description: description
		  }
		});
	  }
	}).then(function (result) {
	  if (result.isConfirmed) {
		if (result.value.success) {
		  Swal.fire('Success!', 'Ethernet data has been updated.', 'success');
		  console.log('Debug Success:', result);
		  $('#interfaces-ethernet').DataTable().ajax.reload();
		} else {
		  Swal.fire('Error!', result.value.message, 'error');
		  console.log('Debug Error:', result);
		}
	  }
	}).catch(function (error) {
	  Swal.fire('Error!', 'Failed to update Ethernet data.', 'error');
	  console.error('Failed to update Ethernet data:', error);
	});
}

//add address
function addAddress() {
  Swal.fire({
    title: 'Add Address',
    html: `
    <form id="addForm">
      <div class="form-group">

        <select id="ethernetName" class="mt-3 form-select">
          <option value="">Choose Ethernet</option>
        </select>

      <input type="text" id="address" class="mt-3 form-control" placeholder="192.168.0.1/24 or DHCP">

      </div>
    </form>
    `,
    didOpen: () => {

      $(document).ready(function() {

        function populateEthernetOptions(data) {
          var ethernetSelect = $('#ethernetName');
          ethernetSelect.empty();
      
          ethernetSelect.append($('<option>', {
            value: '',
            text: 'Choose Ethernet'
          }));
      
          $.each(data.ethernet, function(key, value) {
            ethernetSelect.append($('<option>', {
              value: key,
              text: key
            }));
          });
        }
      
        $.ajax({
          url: 'api/interfaces/interfaces_data.php',
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'interfaces-data'
          },
          success: function(response) {
            if (response.success) {
              populateEthernetOptions(response.data);
            } else {
              console.error('Error fetching Ethernet data');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
          }
        });
      });
          
    },
    showCancelButton: true,
    confirmButtonText: 'Save',
    cancelButtonText: 'Cancel',
    showLoaderOnConfirm: true,
    focusConfirm: false,
    allowOutsideClick: false,
    preConfirm: function() {

      const ethernetName = $('#ethernetName').val();
      const address = $('#address').val();

      if (!ethernetName || !address) {
        Swal.showValidationMessage('All fields are required!');
        return false;
      }

      return $.ajax({
        url: 'api/interfaces/ethernet.php',
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'add-ethernet-address',
          ethernetName: ethernetName,
          address: address,
        }
      });
    }
  }).then(function(result) {
    if (result.isConfirmed) {
      if (result.value.success) {
        Swal.fire('Success!', 'IP address has been added.', 'success');

        console.log('Debug Success:', result);
        $('#ethernet-address').DataTable().ajax.reload();
      } else {
        Swal.fire('Error!', result.value.message, 'error');
        console.log('Debug Error:', result);
      }
    }
  }).catch(function(error) {
    Swal.fire('Error!', 'Failed to add IP address.', 'error');
    console.error('Failed to add IP address:', error);
  });
}

function deleteAddress(data) {

	Swal.fire({
		title: "Delete Address",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">Address -> ${data.address}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/interfaces/ethernet.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'delete-address',
					ethernetName: data.ethernetName,
					address: data.address
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'Address has been deleted.', 'success');
				$('#ethernet-address').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete Address.', 'error');
		console.error('Failed to delete Address:', error);
	});
}