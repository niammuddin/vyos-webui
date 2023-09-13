$(document).ready(function() {
let loadedData = {};
function loadDataTable(tabId) {
	if (tabId === 'ifb' && !loadedData[tabId]) {
	initIFB();
	loadedData[tabId] = true;
	} else if (tabId === 'traffic-policy' && !loadedData[tabId]) {
	initTrafficPolicy();
	loadedData[tabId] = true;

	}
}

function initIFB() {
let ifb = $('#ifb-table').DataTable({
processing: true,
responsive: true,
serverSide: false,
ajax: {
	url: 'api/interfaces/ifb.php',
	type: 'POST',
	dataType: 'json',
	data: {
		action: 'ifb-table'
	}
},
columns: [
	{ data: 'ifb' },
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
						<li><a class="dropdown-item" href="#" onclick="editIFB(${rowData})">Edit</a></li>
						<li><a class="dropdown-item" href="#" onclick="deleteIFB(${rowData})">Delete</a></li>
					</ul>
					</div>`;
		}
	}
],
});
new $.fn.dataTable.FixedHeader( ifb );
}

function initTrafficPolicy(){

	let trafficPolicy = $('#traffic-policy-table').DataTable({
		processing: true,
		responsive: true,
		serverSide: false,
		ajax: {
			url: 'api/interfaces/ifb.php',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'traffic-policy-table'
			}
		},
		columns: [
			{ data: 'ifb' },
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

initIFB();
loadedData['ifb'] = true;
$(".nav-link").on("shown.bs.tab", function(e) {
	let targetTabId = $(e.target).attr("aria-controls");
	if (targetTabId === 'nav-ifb') {
	loadDataTable('ifb');
	} else if (targetTabId === 'nav-traffic-policy') {
	loadDataTable('traffic-policy');
	}
});
});


function addIFB() {
	Swal.fire({
		title: 'Add IFB',
		html: `
		<form id="addForm">
		  <div class="form-group">
			<input type="text" id="ifb" class="mt-3 form-control" placeholder="ifb0-ifb999">
			<input type="text" id="description" class="mt-3 form-control" placeholder="description">
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

			const ifb = $('#ifb').val();
			const description = $('#description').val();

			if (!ifb) {
				Swal.showValidationMessage('All fields are required!');
				return false;
			}

			return $.ajax({
				url: 'api/interfaces/ifb.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'add-ifb',
					ifb: ifb,
					description: description
				}
			});
		}
	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Success!', 'IFB data has been added.', 'success');
				console.log('Debug Success:', result);
				$('#ifb-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', '<span class="text-danger">' + result.value.message + '</span>', 'error');
				console.log('Debug Error:', result);
			}
		}
	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to add IFB data.', 'error');
		console.error('Failed to add IFB data:', error);
	});
}
function deleteIFB(data) {

	Swal.fire({
		title: "Delete IFB",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">IFB -> ${data.ifb}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/interfaces/ifb.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'delete-ifb',
					ifb: data.ifb
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'IFB has been deleted.', 'success');
				$('#ifb-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete IFB.', 'error');
		console.error('Failed to delete IFB:', error);
	});
}
function editIFB(data) {
	Swal.fire({
		title: 'Edit IFB',
		html: `
		<form id="editForm">
		  <div class="form-group">
			<input type="text" id="ifb" class="mt-3 form-control" placeholder="ifb0-ifb999" value="${data.ifb}" disabled>
			<input type="text" id="description" class="mt-3 form-control" placeholder="description" value="${data.description}">
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

			const ifb = $('#ifb').val();
			const description = $('#description').val();

			if (!ifb) {
				Swal.showValidationMessage('All fields are required!');
				return false;
			}

			return $.ajax({
				url: 'api/interfaces/ifb.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'edit-ifb',
					ifb: ifb,
					description: description
				}
			});
		}
	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Success!', 'IFB data has been added Edit.', 'success');
				console.log('Debug Success:', result);
				$('#ifb-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', '<span class="text-danger">' + result.value.message + '</span>', 'error');
				console.log('Debug Error:', result);
			}
		}
	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to edit IFB data.', 'error');
		console.error('Failed to edit IFB data:', error);
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

				<select id="ifb" class="mt-3 form-select">
				<option value="">Choose IFB</option>
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
				
				let ifb = document.getElementById("ifb");

				ifb.innerHTML = '<option value="">Choose IFB</option>';
				for (let ifbKey in data.interfaces['input']) {
					ifb.innerHTML += '<option value="' + ifbKey + '">' + ifbKey + '</option>';
				}


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
  
        const ifbValue = $('#ifb').val();
        const trafficPolicyIn = $('#trafficPolicyIn').val();
        const trafficPolicyOut = $('#trafficPolicyOut').val();
  

		if (!ifbValue) {
			Swal.showValidationMessage('All fields are required!');
			return false;
		}
		

		if (!trafficPolicyIn && !trafficPolicyOut) {
			Swal.showValidationMessage('At least one Traffic Policy is required!');
			return false;
		}
  
        return $.ajax({
          url: 'api/interfaces/ifb.php',
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'add-traffic-policy',
            ifb: ifbValue,
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
			url: 'api/interfaces/ifb.php',
			type: 'POST',
			dataType: 'json',
			data: {
			action: 'delete-traffic-policy',
			ifb: data.ifb,
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