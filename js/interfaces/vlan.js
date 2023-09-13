$(document).ready(function() {
let loadedData = {};
function loadDataTable(tabId) {
	if (tabId === 'vlan' && !loadedData[tabId]) {
	initVlan();
	loadedData[tabId] = true;
	} else if (tabId === 'address' && !loadedData[tabId]) {
	iniAddress();
	loadedData[tabId] = true;
	} else if (tabId === 'traffic-policy' && !loadedData[tabId]) {
	initTrafficPolicy();
	loadedData[tabId] = true;
	} else if (tabId === 'redirect' && !loadedData[tabId]) {
	initRedirect();
	loadedData[tabId] = true;
	}
}

function initVlan() {
let tableVlan = $('#vlan-table').DataTable({
processing: true,
responsive: true,
serverSide: false,
ajax: {
	url: 'api/interfaces/vlan.php',
	type: 'POST',
	dataType: 'json',
	data: {
		action: 'vlan-table'
	}
},
columns: [
	{ data: 'vlanId' },
	{ data: 'iface' },
	{ data: 'ifaceType' },
	{ data: 'description' },
	{
		data: null,
		render: function(data) {
			let rowData = JSON.stringify(data);
            return `<div class="dropdown dropstart">
            <a class="btn btn-icon btn-ghost btn-xs rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
            </a>
	<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
		<li><a class="dropdown-item" href="#" onclick='editVLAN(${rowData})'>Edit</a></li>
		<li><a class="dropdown-item" href="#" onclick='deleteVLAN(${rowData})'>Delete</a></li>
	</ul>
	</div>`;
		}
	}
],
});
new $.fn.dataTable.FixedHeader( tableVlan );
}

function iniAddress() {
// vlan address
let tableVlanAddress = $('#address-table').DataTable({
processing: true,
responsive: true,
serverSide: false,
ajax: {
	url: 'api/interfaces/vlan.php',
	type: 'POST',
	dataType: 'json',
	data: {
		action: 'address-table'
	}
},
columns: [
	{ data: 'address' },
	{
		data: null,
		render: function(data) {
			let vifparentData = data.iface + '.' + data.vif;
			return vifparentData;
		}
	},
	{ data: 'ifaceType' },
	{
		data: null,
		render: function(data) {
			let rowData = JSON.stringify(data);
            return `<div class="dropdown dropstart">
            <a class="btn btn-icon btn-ghost btn-xs rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
            </a>
	<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
		<li><a class="dropdown-item" href="#" onclick='editVlanAddress(${rowData})'>Edit</a></li>
		<li><a class="dropdown-item" href="#" onclick='deleteVlanAddress(${rowData})'>Delete</a></li>
	</ul>
	</div>`;
		}
	}
],
});
new $.fn.dataTable.FixedHeader( tableVlanAddress );
}

function initTrafficPolicy(){

	let trafficPolicy = $('#traffic-policy-table').DataTable({
		processing: true,
		responsive: true,
		serverSide: false,
		ajax: {
			url: 'api/interfaces/vlan.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'traffic-policy-table'
			}
		},
		columns: [
			{ data: 'vlanId' },
			{ data: 'trafficPolicyIn' },
			{ data: 'trafficPolicyOut' },
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
			  <li><a class="dropdown-item" href="#" onclick="deleteTrafficPolicy(${rowData})">Delete</a></li>
			</ul>
		  </div>`;
				}
			}
		],
	  });
	  new $.fn.dataTable.FixedHeader( trafficPolicy );

}

function initRedirect() {
	let tableVlan = $('#redirect-table').DataTable({
	processing: true,
	responsive: true,
	serverSide: false,
	ajax: {
		url: 'api/interfaces/vlan.php',
		type: 'POST',
		dataType: 'json',
		data: {
			action: 'redirect-table'
		}
	},
	columns: [
		{ data: 'vlanId' },
		{ data: 'redirect' },
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
								<li><a class="dropdown-item" href="#" onclick="deleteRedirect(${rowData})">Delete</a></li>
							</ul>
						</div>`;
			}
		}
	],
	});
	new $.fn.dataTable.FixedHeader( tableVlan );
}

initVlan();
loadedData['vlan'] = true;
$(".nav-link").on("shown.bs.tab", function(e) {
	let targetTabId = $(e.target).attr("aria-controls");
	if (targetTabId === 'nav-vlan') {
	loadDataTable('vlan');
	} else if (targetTabId === 'nav-vlan-address') {
	loadDataTable('address');
	} else if (targetTabId === 'nav-traffic-policy') {
	loadDataTable('traffic-policy');
	} else if (targetTabId === 'nav-redirect') {
	loadDataTable('redirect');
	}
});
});

// vlan function
function addVLAN() {
	Swal.fire({
		title: 'Add VLAN',
		html: `
		<form id="addForm">
		  <div class="form-group">
			  <select id="ifaceType" class="mt-3 form-select">
				  <option value="" disabled selected>Choose Type</option>
			  </select>
			  <select id="iface" class="mt-3 form-select">
				  <option value="" disabled selected>Choose Interface</option>
			  </select>
			<input type="number" id="vlanId" class="mt-3 form-control" placeholder="VLAN: 2-4094">
			<input type="text" id="description" class="mt-3 form-control" placeholder="description">
		  </div>
		</form>
	  `,
		didOpen: () => {
			$(document).ready(function() {
				$.ajax({
				  url: 'api/interfaces/interfaces_data.php',
				  type: 'POST',
						dataType: 'json',
						data: {
						  action: 'interfaces-data'
						},
				  success: function(response) {
					data = response;
					let ifaceType = document.getElementById("ifaceType");
					let iface = document.getElementById("iface");
				

					ifaceType.innerHTML = '<option value="">Choose Type</option>';
					for (let ifaceTypeKey in data.data) {
					  ifaceType.innerHTML += '<option value="' + ifaceTypeKey + '">' + ifaceTypeKey + '</option>';
					}
				

					ifaceType.addEventListener("change", function() {
					  let selectedType = this.value;
					  let interface = data.data[selectedType];
					  iface.innerHTML = '<option value="">Choose Interface</option>';
					  if (interface) {
						for (let ifaceKey in interface) {
						  iface.innerHTML += '<option value="' + ifaceKey + '">' + ifaceKey + '</option>';
						}
					  } else {

						iface.innerHTML = '<option value="">Choose Interface</option>';
					  }
					});
				  },
				  error: function(xhr, status, error) {
					console.error('Error:', status, error);
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

			const ifaceType = $('#ifaceType').val();
			const iface = $('#iface').val();
			const vlanId = $('#vlanId').val();
			const description = $('#description').val();


			if (!ifaceType || !iface || !vlanId || !description) {
				Swal.showValidationMessage('All fields are required!');
				return false;
			}

			return $.ajax({
				url: 'api/interfaces/vlan.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'addVlan',
					vlanId: vlanId,
					ifaceType: ifaceType,
					iface: iface,
					description: description
				}
			});
		}
	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Success!', 'VLAN data has been added.', 'success');

				console.log('Debug Success:', result);
				$('#vlan-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.log('Debug Error:', result);
			}
		}
	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to add VLAN data.', 'error');
		console.error('Failed to add VLAN data:', error);
	});
}

function editVLAN(data) {
	Swal.fire({
	  title: 'Edit VLAN',
	  html: `
		<form id="editForm">
		<div class="form-group">
		<input type="text" id="iface" class="mt-3 form-control" value="${data.iface}" disabled>
		<input type="text" id="vlanId" class="mt-3 form-control" value="${data.vlanId}" disabled>
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

		const ifaceType = data.ifaceType;
		const iface = data.iface;
		const vlanId = data.vlanId;
        const description = $('#description').val();

        if (
			description === data.description
        ) {
          Swal.fire('No Changes', 'There are no changes to save.', 'info');
          return false;
          }
  
		return $.ajax({
		  url: 'api/interfaces/vlan.php',
		  type: 'POST',
		  dataType: 'json',
		  data: {
			action: 'editVlan',
			vlanId: vlanId,
			iface: iface,
			ifaceType: ifaceType,
			description: description
		  }
		});
	  }
	}).then(function (result) {
	  if (result.isConfirmed) {
		if (result.value.success) {
		  Swal.fire('Success!', 'VLAN data has been updated.', 'success');
		  // Refresh tabel setelah berhasil update data
		  console.log('Debug Success:', result);
		  $('#vlan-table').DataTable().ajax.reload();
		} else {
		  Swal.fire('Error!', result.value.message, 'error');
		  console.log('Debug Error:', result);
		}
	  }
	}).catch(function (error) {
	  Swal.fire('Error!', 'Failed to update VLAN data.', 'error');
	  console.error('Failed to update VLAN data:', error);
	});
}

function deleteVLAN(data) {

	Swal.fire({
		title: "Delete VLAN",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">VLAN -> ${data.vlanId}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/interfaces/vlan.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'deleteVlan',
					vlanId: data.vlanId,
					iface: data.iface,
					ifaceType: data.ifaceType
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'VLAN has been deleted.', 'success');
				$('#vlan-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete VLAN.', 'error');
		console.error('Failed to delete VLAN:', error);
	});
}

// vlan address function
function addVlanAddress() {
    Swal.fire({
      title: 'Add VLAN Address',
      html: `
      <form id="addForm">
        <div class="form-group">
          <select id="ifaceType" class="mt-3 form-select">
            <option value="">Choose Type</option>
          </select>
          <select id="iface" class="mt-3 form-select">
            <option value="">Choose Interface</option>
          </select>
          <select id="vlanId" class="mt-3 form-select">
            <option value="">Choose VLAN</option>
          </select>
        <input type="text" id="address" class="mt-3 form-control" placeholder="IP address: 192.168.0.1/24">
        </div>
      </form>
      `,
      didOpen: () => {
        $(document).ready(function() {
          $.ajax({
            url: 'api/interfaces/interfaces_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'interfaces-data'
            },
            success: function(response) {
              data = response;
              let ifaceType = document.getElementById("ifaceType");
              let iface = document.getElementById("iface");
              let vlanId = document.getElementById("vlanId");
          

              ifaceType.innerHTML = '<option value="">Choose Type</option>';
              for (let ifaceTypeKey in data.data) {
                ifaceType.innerHTML += '<option value="' + ifaceTypeKey + '">' + ifaceTypeKey + '</option>';
              }
          

              ifaceType.addEventListener("change", function() {
                let selectedType = this.value;
                let interface = data.data[selectedType];
                iface.innerHTML = '<option value="">Choose Interface</option>';
                if (interface) {
                  for (let ifaceKey in interface) {
                    iface.innerHTML += '<option value="' + ifaceKey + '">' + ifaceKey + '</option>';
                  }

                  iface.dispatchEvent(new Event("change"));
                } else {

                  iface.innerHTML = '<option value="">Choose Interface</option>';
                  vlanId.innerHTML = '<option value="">Choose VLAN</option>';
                }
              });
          

              iface.addEventListener("change", function() {
                let selectedType = ifaceType.value;
                let selectedInterface = this.value;
                let vifData = data.data[selectedType] && data.data[selectedType][selectedInterface] ? data.data[selectedType][selectedInterface].vif : null;
                vlanId.innerHTML = '<option value="">Choose VLAN</option>';
                if (vifData) {
                  for (let vifKey in vifData) {
                    vlanId.innerHTML += '<option value="' + vifKey + '">' + vifKey + '</option>';
                  }
                }
              });
            },
            error: function(xhr, status, error) {
              console.error('Error:', status, error);
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
  
        const ifaceType = $('#ifaceType').val();
        const iface = $('#iface').val();
        const vlanId = $('#vlanId').val();
        const address = $('#address').val();
  

        if (!ifaceType || !iface || !vlanId || !address) {
          Swal.showValidationMessage('All fields are required!');
          return false; 
        }
  
        return $.ajax({
          url: 'api/interfaces/vlan.php',
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'addVlanAddress',
            vlanId: vlanId,
            ifaceType: ifaceType,
            iface: iface,
            address: address,
          }
        });
      }
    }).then(function(result) {
      if (result.isConfirmed) {
        if (result.value.success) {
          Swal.fire('Success!', 'IP address has been added.', 'success');

          console.log('Debug Success:', result);
          $('#address-table').DataTable().ajax.reload();
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

function editVlanAddress(data) {
Swal.fire({
	title: 'Edit VLAN Address',
	html: `
	<form id="addForm">
	<div class="form-group">
	<input type="text" id="newAddress" class="mt-3 form-control" value="${data.address}" placeholder="192.168.0.1/24">
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
	const newAddress = $('#newAddress').val();
	if (
		newAddress === data.address
	) {
		Swal.fire('No Changes', 'There are no changes to save.', 'info');
		return false;
		}

	return $.ajax({
		url: 'api/interfaces/vlan.php',
		type: 'POST',
		dataType: 'json',
		data: {
		action: 'editVlanAddress',
		newAddress: newAddress,
		ifaceType: data.ifaceType,
		iface: data.iface,
		vlanId: data.vif,
		oldAddress: data.address
		}
	});
	}
}).then(function(result) {
	if (result.isConfirmed) {
	if (result.value.success) {
		Swal.fire('Success!', 'Success Edit VLAN Address.', 'success');

		console.log('Debug Success:', result);
		$('#address-table').DataTable().ajax.reload();
	} else {
		Swal.fire('Error!', result.value.message, 'error');
		console.log('Debug Error:', result);
	}
	}
}).catch(function(error) {
	Swal.fire('Error!', 'Failed to edit IP address.', 'error');
	console.error('Failed to edit IP address:', error);
});
}

function deleteVlanAddress(data) {
Swal.fire({
	title: "Delete VLAN Address",
	html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">IP -> ${data.address}</small>`,
	icon: "warning",
	confirmButtonText: "Delete",
	showCancelButton: true,
	showLoaderOnConfirm: true,
	allowOutsideClick: true,
	backdrop: true,
	preConfirm: function() {
	return $.ajax({
		url: 'api/interfaces/vlan.php',
		type: 'POST',
		dataType: 'json',
		data: {
		action: 'deleteVlanAddress',
		vlanId: data.vif,
		iface: data.iface,
		ifaceType: data.ifaceType,
		address: data.address
		}
	});
	},

}).then(function(result) {
	if (result.isConfirmed) {
	if (result.value.success) {
		Swal.fire('Deleted!', 'IP has been deleted.', 'success');
		$('#address-table').DataTable().ajax.reload();
		console.log('debug success:', result);
	} else {
		Swal.fire('Error!', result.value.message, 'error');
		console.error('debug error:', result);
	}
	}

}).catch(function(error) {
	Swal.fire('Error!', 'Failed to delete IP.', 'error');
	console.error('Failed to delete IP:', error);
});
}

// add traffic policy function
function addTrafficPolicy() {
	let modalContent = '<div class="mt-3 mb-10"><div class="dataTables_processing" role="status"><div><div></div><div></div><div></div><div></div></div></div></div>';
    Swal.fire({
      title: 'Add Traffic Policy',
      html: modalContent,
      didOpen: () => {
        $(document).ready(function() {
          $.ajax({
            url: 'api/config/config.php',
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'get-config'
            },
            success: function(response) {

				let modalContent = `
				<form id="addForm">
				<div class="form-group">

				<select id="ifaceType" class="mt-3 form-select">
				<option value="">Choose Type</option>
				</select>

				<select id="iface" class="mt-3 form-select">
				<option value="">Choose Interface</option>
				</select>

				<select id="vlanId" class="mt-3 form-select">
				<option value="">Choose VLAN</option>
				</select>

				<select id="trafficPolicyIn" class="mt-3 form-select">
				<option value="">Choose Traffic Policy In</option>
				</select>

				<select id="trafficPolicyOut" class="mt-3 form-select">
				<option value="">Choose Traffic Policy Out</option>
				</select>

				</div>
				</form>`;
				Swal.update({ html: modalContent });

				data = response.data;
				let ifaceType = document.getElementById("ifaceType");
				let iface = document.getElementById("iface");
				let vlanId = document.getElementById("vlanId");

              ifaceType.innerHTML = '<option value="">Choose Type</option>';
              for (let ifaceTypeKey in data.interfaces) {
                ifaceType.innerHTML += '<option value="' + ifaceTypeKey + '">' + ifaceTypeKey + '</option>';
              }
          
 
              ifaceType.addEventListener("change", function() {
                let selectedType = this.value;
                let interface = data.interfaces[selectedType];
                iface.innerHTML = '<option value="">Choose Interface</option>';
                if (interface) {
                  for (let ifaceKey in interface) {
                    iface.innerHTML += '<option value="' + ifaceKey + '">' + ifaceKey + '</option>';
                  }

                  iface.dispatchEvent(new Event("change"));
                } else {

                  iface.innerHTML = '<option value="">Choose Interface</option>';
                  vlanId.innerHTML = '<option value="">Choose VLAN</option>';
                }
              });
          

              iface.addEventListener("change", function() {
                let selectedType = ifaceType.value;
                let selectedInterface = this.value;
                let vifData = data.interfaces[selectedType] && data.interfaces[selectedType][selectedInterface] ? data.interfaces[selectedType][selectedInterface].vif : null;
                vlanId.innerHTML = '<option value="" selected disabled>Choose VLAN</option>';
                if (vifData) {
                  for (let vifKey in vifData) {
                    vlanId.innerHTML += '<option value="' + vifKey + '">' + vifKey + '</option>';
                  }
                }
              });


				let limiterData = data['traffic-policy']['limiter'];
				let shaperData = data['traffic-policy']['shaper'];

				let trafficPolicyInDropdown = document.getElementById("trafficPolicyIn");
				let trafficPolicyOutDropdown = document.getElementById("trafficPolicyOut");


				trafficPolicyInDropdown.innerHTML = '<option value="" selected>Choose Traffic Policy In</option>';
				for (let limiterKey in limiterData) {
					trafficPolicyInDropdown.innerHTML += '<option value="' + limiterKey + '">' + limiterKey + '</option>';
				}


				trafficPolicyOutDropdown.innerHTML = '<option value="" selected>Choose Traffic Policy Out</option>';
				for (let shaperKey in shaperData) {
					trafficPolicyOutDropdown.innerHTML += '<option value="' + shaperKey + '">' + shaperKey + '</option>';
				}
            },
            error: function(xhr, status, error) {
              console.error('Error:', status, error);
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
  
        const ifaceType = $('#ifaceType').val();
        const iface = $('#iface').val();
        const vlanId = $('#vlanId').val();
        const trafficPolicyIn = $('#trafficPolicyIn').val();
        const trafficPolicyOut = $('#trafficPolicyOut').val();
  

		if (!ifaceType || !iface || !vlanId) {
			Swal.showValidationMessage('All fields are required!');
			return false;
		}
		

		if (!trafficPolicyIn && !trafficPolicyOut) {
			Swal.showValidationMessage('At least one Traffic Policy is required!');
			return false;
		}
  
        return $.ajax({
          url: 'api/interfaces/vlan.php',
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'add-traffic-policy',
            vlanId: vlanId,
            ifaceType: ifaceType,
            iface: iface,
            trafficPolicyIn: trafficPolicyIn,
            trafficPolicyOut: trafficPolicyOut
          }
        });
      }
    }).then(function(result) {
      if (result.isConfirmed) {
        if (result.value.success) {
          Swal.fire('Success!', 'Traffic Policy has been added.', 'success');

          console.log('Debug Success:', result);
          $('#traffic-policy-table').DataTable().ajax.reload();
        } else {
          Swal.fire('Error!', result.value.message, 'error');
          console.log('Debug Error:', result);
        }
      }
    }).catch(function(error) {
      Swal.fire('Error!', 'Failed to add Traffic Policy.', 'error');
      console.error('Failed to add Traffic Policy:', error);
    });
}

function deleteTrafficPolicy(data) {
	Swal.fire({
		title: "Delete Traffic Policy",
		html: `Are you sure you want to delete?`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
		return $.ajax({
			url: 'api/interfaces/vlan.php',
			type: 'POST',
			dataType: 'json',
			data: {
			action: 'delete-traffic-policy',
			vlanId: data.vlanId,
			iface: data.iface,
			ifaceType: data.ifaceType,
			trafficPolicyIn: data.trafficPolicyIn,
			trafficPolicyOut: data.trafficPolicyOut
			}
		});
		},
	
	}).then(function(result) {
		if (result.isConfirmed) {
		if (result.value.success) {
			Swal.fire('Deleted!', 'Traffic Policy has been deleted.', 'success');
			$('#traffic-policy-table').DataTable().ajax.reload();
			console.log('debug success:', result);
		} else {
			Swal.fire('Error!', result.value.message, 'error');
			console.error('debug error:', result);
		}
		}
	
	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete Traffic Policy.', 'error');
		console.error('Failed to delete Traffic Policy:', error);
	});
}

// add redirect function
function addRedirect() {
	let modalContent = '<div class="mt-3 mb-10"><div class="dataTables_processing" role="status"><div><div></div><div></div><div></div><div></div></div></div></div>';
    Swal.fire({
      title: 'Add Redirect',
      html: modalContent,
      didOpen: () => {
        $(document).ready(function() {
          $.ajax({
            url: 'api/config/config.php',
            type: 'POST',
            dataType: 'json',
            data: {
              action: 'get-config'
            },
            success: function(response) {

				let modalContent = `
				<form id="addForm">
				<div class="form-group">

				<select id="ifaceType" class="mt-3 form-select">
				<option value="">Choose Type</option>
				</select>

				<select id="iface" class="mt-3 form-select">
				<option value="">Choose Interface</option>
				</select>

				<select id="vlanId" class="mt-3 form-select">
				<option value="">Choose VLAN</option>
				</select>

				<select id="ifb" class="mt-3 form-select">
				<option value="">Choose IFB</option>
				</select>

				</div>
				</form>`;
				Swal.update({ html: modalContent });

				data = response.data;
				let ifaceType = document.getElementById("ifaceType");
				let iface = document.getElementById("iface");
				let vlanId = document.getElementById("vlanId");

              ifaceType.innerHTML = '<option value="">Choose Type</option>';
              for (let ifaceTypeKey in data.interfaces) {
                ifaceType.innerHTML += '<option value="' + ifaceTypeKey + '">' + ifaceTypeKey + '</option>';
              }
          
              ifaceType.addEventListener("change", function() {
                let selectedType = this.value;
                let interface = data.interfaces[selectedType];
                iface.innerHTML = '<option value="">Choose Interface</option>';
                if (interface) {
                  for (let ifaceKey in interface) {
                    iface.innerHTML += '<option value="' + ifaceKey + '">' + ifaceKey + '</option>';
                  }

                  iface.dispatchEvent(new Event("change"));
                } else {

                  iface.innerHTML = '<option value="">Choose Interface</option>';
                  vlanId.innerHTML = '<option value="">Choose VLAN</option>';
                }
              });
          

              iface.addEventListener("change", function() {
                let selectedType = ifaceType.value;
                let selectedInterface = this.value;
                let vifData = data.interfaces[selectedType] && data.interfaces[selectedType][selectedInterface] ? data.interfaces[selectedType][selectedInterface].vif : null;
                vlanId.innerHTML = '<option value="" selected disabled>Choose VLAN</option>';
                if (vifData) {
                  for (let vifKey in vifData) {
                    vlanId.innerHTML += '<option value="' + vifKey + '">' + vifKey + '</option>';
                  }
                }
              });


				let ifbData = data.interfaces['input'];
				let ifbDropdown = document.getElementById("ifb");
				ifbDropdown.innerHTML = '<option value="" selected>Choose IFB</option>';
				for (let ifbKey in ifbData) {
					ifbDropdown.innerHTML += '<option value="' + ifbKey + '">' + ifbKey + '</option>';
				}

            },
            error: function(xhr, status, error) {
              console.error('Error:', status, error);
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
  
        const ifaceType = $('#ifaceType').val();
        const iface = $('#iface').val();
        const vlanId = $('#vlanId').val();
        const ifb = $('#ifb').val();


		if (!ifaceType || !iface || !vlanId || !ifb) {
			Swal.showValidationMessage('All fields are required!');
			return false;
		}
  
        return $.ajax({
          url: 'api/interfaces/vlan.php',
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'add-redirect',
            vlanId: vlanId,
            ifaceType: ifaceType,
            iface: iface,
            ifb: ifb
          }
        });
      }
    }).then(function(result) {
      if (result.isConfirmed) {
        if (result.value.success) {
          Swal.fire('Success!', 'Redirect ifb has been added.', 'success');
          console.log('Debug Success:', result);
          $('#redirect-table').DataTable().ajax.reload();
        } else {
          Swal.fire('Error!', result.value.message, 'error');
          console.log('Debug Error:', result);
        }
      }
    }).catch(function(error) {
      Swal.fire('Error!', 'Failed to add Redirect ifb.', 'error');
      console.error('Failed to add Redirect ifb:', error);
    });
}

function deleteRedirect(data) {

	Swal.fire({
		title: "Delete Redirect",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">IFB -> ${data.redirect}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/interfaces/vlan.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'delete-redirect',
					vlanId: data.vlanId,
					iface: data.iface,
					ifaceType: data.ifaceType,
					redirect: data.redirect
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'Redirect has been deleted.', 'success');
				$('#redirect-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete Redirect.', 'error');
		console.error('Failed to delete Redirect:', error);
	});
}