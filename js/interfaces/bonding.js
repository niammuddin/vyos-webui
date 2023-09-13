$(document).ready(function() {
  let loadedData = {};

  function loadDataTable(tabId) {
    if (tabId === 'bonding' && !loadedData[tabId]) {
      initBondingTable();
      loadedData[tabId] = true;
    } else if (tabId === 'bond-address' && !loadedData[tabId]) {
      initBondingAddressTable();
      loadedData[tabId] = true;
    }
  }

  function initBondingTable() {

    var bonding = $('#interfaces-bonding').DataTable({
    processing: true,
    responsive: true,
    serverSide: false,
    ajax: {
      url: 'api/interfaces/bonding.php',
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'bonding-table'
      }
    },
    columns: [
      { data: 'interface' },
      { data: 'mode' },
      { data: 'hashpolicy' },
      { data: 'memberinterface' },
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
      <li><a class="dropdown-item" href="#" onclick='editBonding(${rowData})'>Edit</a></li>
      <li><a class="dropdown-item" href="#" onclick='deleteBonding(${rowData})'>Delete</a></li>
    </ul>
  </div>`;
        }
    }
    ],
  });
  new $.fn.dataTable.FixedHeader( bonding );
  }

  function initBondingAddressTable() {

  var bondingAddress = $('#bonding-address').DataTable({
    processing: true,
    responsive: true,
    serverSide: false,
    ajax: {
      url: 'api/interfaces/bonding.php',
      type: 'POST',
      dataType: 'json',
      data: {
        action: 'address-table'
      }
    },
    columns: [
      { data: 'interface' },
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
  new $.fn.dataTable.FixedHeader( bondingAddress );
  }
  

  initBondingTable();
  loadedData['bonding'] = true;


  $(".nav-link").on("shown.bs.tab", function(e) {
    let targetTabId = $(e.target).attr("aria-controls");
    if (targetTabId === 'nav-bonding') {
      loadDataTable('bonding');
    } else if (targetTabId === 'nav-bond-address') {
      loadDataTable('bond-address');
    }
  });
});
  
// add bonding
function addBonding() {
	Swal.fire({
		title: 'Add Bonding',
		html: `
		<form id="formAddBonding">
		  <div class="form-group">

      <input type="text" id="bondName" class="mt-3 form-control" placeholder="example: bond100">
      <select id="bondMode" class="mt-3 form-select">
        <option value="" disabled selected>Choose Mode</option>
        <option value="802.3ad">802.3ad</option>
        <option value="active-backup">active-backup</option>
        <option value="broadcast">broadcast</option>
        <option value="round-robin">round-robin</option>
        <option value="transmit-load-balance">transmit-load-balance</option>
        <option value="adaptive-load-balance">adaptive-load-balance</option>
        <option value="xor-hash">xor-hash</option>
      </select>

      <select id="hashPolicy" class="mt-3 form-select">
        <option value="" disabled selected>Choose Hash Policy</option>
        <option value="layer2">layer2</option>
        <option value="layer2+3">layer2+3</option>
        <option value="layer3+4">layer3+4</option>
        <option value="encap2+3">encap2+3</option>
        <option value="encap3+4">encap3+4</option>
      </select>

      <div id="MemberContainer">
        <div class="input-group member-entry mt-3">
          <select name="bondMember[]" class="form-select">
            <option value="" selected disabled>Member Interfaces</option>
          </select>
            <button class="btn btn-bg-custom" type="button" id="addMember">+</button>
        </div>
      </div>

		  </div>
		</form>
	  `,
		didOpen: () => {
      $(document).ready(function () {
        const addMember = $("#addMember");
        const memberContainer = $("#MemberContainer");
      

        let ethernetOptionsData = null;
      
        function populateEthernetOptions(selectElement) {
          if (ethernetOptionsData) {
            selectElement.html(ethernetOptionsData);
            const selectedValue = selectElement.data('selected');
            if (selectedValue) {
              selectElement.val(selectedValue);
            }
          }
        }
        function updateAllDropdowns() {
          const allSelectElements = $("select[name='bondMember[]']");
          allSelectElements.each(function () {
            const selectedValue = $(this).val();
            $(this).data('selected', selectedValue);
            populateEthernetOptions($(this));
          });
        }

        $.ajax({
          url: 'api/interfaces/interfaces_data.php',
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'interfaces-data'
          },
          success: function (response) {
            const ethernetData = response.data.ethernet;
            const selectOptions = [];
            selectOptions.push(`<option value="" selected disabled>Member Interfaces</option>`);
            for (const eth in ethernetData) {
              selectOptions.push(`<option value="${eth}">${eth}</option>`);
            }
            ethernetOptionsData = selectOptions.join("");
            updateAllDropdowns();
          }
        });
        addMember.click(function () {
          const newMemberEntry = `
            <div class="input-group member-entry mt-3">
              <select name="bondMember[]" class="form-select">
              <option value="" selected disabled>Member Interfaces</option>
              </select>
              <button class="btn btn-outline-danger remove-members" type="button">-</button>
            </div>
          `;
          memberContainer.append(newMemberEntry);
          updateAllDropdowns();
        });
        memberContainer.on('click', '.remove-members', function () {
          $(this).parent().remove();
          updateAllDropdowns();
        });
      });
		},
		showCancelButton: true,
		confirmButtonText: 'Add',
		cancelButtonText: 'Cancel',
		showLoaderOnConfirm: true,
		focusConfirm: false,
		allowOutsideClick: false,
		preConfirm: function() {
      const bondMemberinput = $("select[name='bondMember[]']");
      const bondMember = bondMemberinput.map(function () {
        return $(this).val();
      }).get();
			const bondName = $('#bondName').val();
			const bondMode = $('#bondMode').val();
			const hashPolicy = $('#hashPolicy').val();
			if (!bondName || !bondMode || !hashPolicy || !bondMember) {
				Swal.showValidationMessage('All fields are required!');
				return false;
			}
			return $.ajax({
				url: 'api/interfaces/bonding.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'add-bonding',
					bondName: bondName,
					bondMode: bondMode,
					hashPolicy: hashPolicy,
					bondMember: bondMember
				}
			});
		}
	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Success!', 'bonding data has been added.', 'success');

				console.log('Debug Success:', result);
				$('#interfaces-bonding').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.log('Debug Error:', result);
			}
		}
	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to add bonding.', 'error');
		console.error('Failed to add bonding:', error);
	});
}

// delete bonding
function deleteBonding(data) {
	Swal.fire({
		title: "Delete Bonding",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">Bonding -> ${data.interface}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/interfaces/bonding.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'delete-bonding',
					bondName: data.interface,
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'Bonding has been deleted.', 'success');
				$('#interfaces-bonding').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete Bonding.', 'error');
		console.error('Failed to delete Bonding:', error);
	});
}

// editBonding
function editBonding(data) {
  let modalContent = '<div class="mt-3 mb-10"><div class="dataTables_processing" role="status"><div><div></div><div></div><div></div><div></div></div></div></div>';
  Swal.fire({
      title: 'Edit Bonding',
      html: modalContent,
      showCancelButton: true,
      showLoaderOnConfirm: true,
      confirmButtonText: 'Save',
      cancelButtonText: 'Cancel',
      didOpen: () => {
          $.ajax({
              url: 'api/interfaces/interfaces_data.php',
              type: 'GET',
              dataType: 'json',
              data: {
                action: 'interfaces-data'
              },
              success: function(responseData) {
                  jsonData = responseData;
                  ethernetInterfaces = Object.keys(jsonData.data.ethernet);

                  modalContent = createEditForm(data, ethernetInterfaces);
                  Swal.update({ html: modalContent });
              },
              error: function(error) {
                  Swal.update({ html: '<div>Error loading data.</div>', icon: 'error' });
                  console.log('Error fetching data:', error);
              }
          });
      },
      preConfirm: () => {
        function getFormData() {
          const bondMode = document.getElementById("bondMode").value;
          const hashPolicy = document.getElementById("hashPolicy").value;
          const slaveSelects = document.querySelectorAll(".slaveRow select");
          let memberInterface;
      
          if (slaveSelects.length === 0) {
              memberInterface = [null];
          } else {
              memberInterface = Array.from(slaveSelects).map(select => select.value);
          }
      
          return {
              bondMode: bondMode,
              hashPolicy: hashPolicy,
              memberInterface: memberInterface
          };
      }
      
      
      const formData = getFormData();
      const isBondModeChanged = formData.bondMode !== data.mode;
      const isHashPolicyChanged = formData.hashPolicy !== data.hashpolicy;
      
      const originalMemberInterfaces = data.memberinterface.split(',').map(s => s.trim());
      let isMembersChanged = !(originalMemberInterfaces.every((val, index) => val === formData.memberInterface[index]) 
                                  && originalMemberInterfaces.length === formData.memberInterface.length);
  
      const isMembersInitiallyEmpty = originalMemberInterfaces.length === 0 || (originalMemberInterfaces.length === 1 && originalMemberInterfaces[0] === "");
      const isFormDataMembersEmpty = formData.memberInterface[0] === null;
  
      if (isMembersInitiallyEmpty && isFormDataMembersEmpty) {
          isMembersChanged = false;
      }
  
      if (!isBondModeChanged && !isHashPolicyChanged && !isMembersChanged) {
        Swal.fire('No Changes', 'There are no changes to save.', 'info');
        return false;
    }
    

    if (formData.memberInterface[0] === null) {
        formData.memberInterface = ["deleteMemberInterface"];
    }

    let postData = {
        action: 'edit-bonding',
        bondName: data.interface,
        bondMode: isBondModeChanged ? formData.bondMode : "",
        hashPolicy: isHashPolicyChanged ? formData.hashPolicy : "",
        memberInterface: isMembersChanged ? formData.memberInterface : []
    };


  return $.ajax({
      url: 'api/interfaces/bonding.php',
      type: 'POST',
      dataType: 'json',
      data: postData
  });
      }
    }).then(function (result) {
      if (result.isConfirmed) {
      if (result.value.success) {
        Swal.fire('Success!', 'Bonding data has been updated.', 'success');
        console.log('Debug Success:', result);
        $('#interfaces-bonding').DataTable().ajax.reload();
      } else {
        Swal.fire('Error!', result.value.message, 'error');
        console.log('Debug Error:', result);
      }
      }
    }).catch(function (error) {
      Swal.fire('Error!', 'Failed to update Bonding data.', 'error');
      console.error('Failed to update Bonding data:', error);
    });
}

function createEditForm(data, ethernetInterfaces) {
  let modalContent = `
      <div id="modalFormContainer">
          <input type="text" id="bondName" class="mt-3 form-control" placeholder="${data.interface}" disabled>
  `;

  modalContent += `
      <select id="bondMode" class="mt-3 form-select">
  `;

  const bondModes = [
      '802.3ad', 'active-backup', 'broadcast', 'round-robin', 'transmit-load-balance', 
      'adaptive-load-balance', 'xor-hash'
  ];
  bondModes.forEach(mode => {
      modalContent += `
          <option value="${mode}" ${data.mode === mode ? 'selected' : ''}>${mode}</option>
      `;
  });

  modalContent += '</select>';

  modalContent += `
      <select id="hashPolicy" class="mt-3 form-select">
  `;

  const hashPolicies = ['layer2', 'layer2+3', 'layer3+4', 'encap2+3', 'encap3+4'];
  hashPolicies.forEach(policy => {
      modalContent += `
          <option value="${policy}" ${data.hashpolicy === policy ? 'selected' : ''}>${policy}</option>
      `;
  });

  modalContent += '</select>';
  modalContent += `
      <div class="input-group mt-3">
          <button class="mt-3 btn btn-sm btn-outline-primary" type="button" onclick="tambahSlave(document.getElementById('modalFormContainer'))">+ Add Member Interface</button>
      </div>
  `;

  const slaveInterfaces = data.memberinterface.split(',').map(s => s.trim());
  if (slaveInterfaces.length > 0 && slaveInterfaces[0] !== "") {
      slaveInterfaces.forEach(item => {
          modalContent += '<div class="slaveRow input-group mt-3"><select class="form-select">';
          ethernetInterfaces.forEach(interface => {
              modalContent += `
                  <option value="${interface}" ${item === interface ? 'selected' : ''}>${interface}</option>
              `;
          });
          modalContent += `
              </select>
              <button class="btn btn-outline-danger" onclick="hapusBaris(this)">-</button>
              </div>
          `;
      });
  }
  

  modalContent += '</div>';

  return modalContent;
}

function tambahSlave(container) {
      const newSelect = document.createElement('select');
      newSelect.className = 'form-select';
      const defaultOption = document.createElement('option');
      defaultOption.value = "";
      defaultOption.textContent = "-- Choose Interface --";
      newSelect.appendChild(defaultOption);

      ethernetInterfaces.forEach(interface => {
          const option = document.createElement('option');
          option.value = interface;
          option.textContent = interface;
          newSelect.appendChild(option);
      });

      const removeBtn = document.createElement('button');
      removeBtn.className = 'btn btn-outline-danger';
      removeBtn.textContent = '-';
      removeBtn.onclick = function () {
          hapusBaris(removeBtn);
      };

      const newRow = document.createElement('div');
      newRow.className = 'slaveRow input-group mt-3';
      newRow.appendChild(newSelect);
      newRow.appendChild(removeBtn);

      container.appendChild(newRow);
}

function hapusBaris(button) {
      const row = button.parentNode;
      row.parentNode.removeChild(row);
}

// add address
function addAddress() {
  Swal.fire({
    title: 'Add Address',
    html: `
    <form id="addForm">
      <div class="form-group">

        <select id="bondName" class="mt-3 form-select">
          <option value="">Choose Interface</option>
        </select>

      <input type="text" id="address" class="mt-3 form-control" placeholder="192.168.0.1/24">

      </div>
    </form>
    `,
    didOpen: () => {

      $(document).ready(function() {

        function populateBondOptions(data) {
          var bondSelect = $('#bondName');
          bondSelect.empty(); 
      
          bondSelect.append($('<option>', {
            value: '',
            text: 'Choose Interface'
          }));
      
          $.each(data.bonding, function(key, value) {
            bondSelect.append($('<option>', {
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
              populateBondOptions(response.data);
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

      const bondName = $('#bondName').val();
      const address = $('#address').val();


      if (!bondName || !address) {
        Swal.showValidationMessage('All fields are required!');
        return false; 
      }

      return $.ajax({
        url: 'api/interfaces/bonding.php',
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'add-bonding-address',
          bondName: bondName,
          address: address,
        }
      });
    }
    
  }).then(function(result) {
    if (result.isConfirmed) {
      if (result.value.success) {
        Swal.fire('Success!', 'IP address has been added.', 'success');
        console.log('Debug Success:', result);
        $('#bonding-address').DataTable().ajax.reload();
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

// delete address
function deleteAddress(data) {
  Swal.fire({
    title: "Delete Address",
    html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">IP -> ${data.address}</small>`,
    icon: "warning",
    confirmButtonText: "Delete",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    allowOutsideClick: true,
    backdrop: true,
    preConfirm: function() {
    return $.ajax({
      url: 'api/interfaces/bonding.php',
      type: 'POST',
      dataType: 'json',
      data: {
      action: 'delete-bonding-address',
      bondName: data.interface,
      address: data.address
      }
    });
    },
  
  }).then(function(result) {
    if (result.isConfirmed) {
    if (result.value.success) {
      Swal.fire('Deleted!', 'IP has been deleted.', 'success');
      $('#bonding-address').DataTable().ajax.reload();
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