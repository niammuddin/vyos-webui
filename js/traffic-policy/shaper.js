$(document).ready(function() {
  let loadedData = {};
  function loadDataTable(tabId) {
    if (tabId === 'shaper' && !loadedData[tabId]) {
      initShaper();
    loadedData[tabId] = true;
    } else if (tabId === 'class' && !loadedData[tabId]) {
      initClass();
    loadedData[tabId] = true;
    } else if (tabId === 'match' && !loadedData[tabId]) {
      initMatch();
    loadedData[tabId] = true;
    }
  }

  function initShaper(){
    var shaperList = $('#shaper-table').DataTable({
      processing: true,
      responsive: true,
      serverSide: false,
      ajax: {
        url: 'api/traffic-policy/shaper.php',
        type: 'POST',
      },
      columns: [
        {data: 'shaperName'},
        {data: 'bandwidth'},
        {data: 'defaultBandwidth'},
        {data: 'defaultBurst'},
        {data: 'defaultQueueType'},
        {data: 'description'},
        {
          data: null,
          render: function(data) {
            var rowData = JSON.stringify(data);
            return `<div class="dropdown dropstart">
            <a class="btn btn-icon btn-ghost btn-xs rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
            </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#" onclick='editShaper(${rowData})'>Edit</a></li>
                <li><a class="dropdown-item" href="#" onclick='deleteShaper(${rowData})'>Delete</a></li>
              </ul>
            </div>`;
          }
        }
      ],
    });
    new $.fn.dataTable.FixedHeader(shaperList);
  }

  function initClass() {
    var shaperClass = $('#class-table').DataTable({
    processing: true,
    responsive: true,
    serverSide: false,
    ajax: {
      url: 'api/traffic-policy/class.php',
      type: 'POST',
    },
    columns: [
      { data: 'shaperName' },
      { data: 'classId' },
      { data: 'match' },
      { data: 'bandwidth' },
      { data: 'burst' },
      { data: 'queueType' },
      { data: 'description' },
      {
				data: null,
				render: function(data) {
					var rowData = JSON.stringify(data);
          return `<div class="dropdown dropstart">
          <a class="btn btn-icon btn-ghost btn-xs rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
          </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
              <li><a class="dropdown-item" href="#" onclick='editClass(${rowData})'>Edit</a></li>
              <li><a class="dropdown-item" href="#" onclick='deleteClass(${rowData})'>Delete</a></li>
            </ul>
          </div>`;
				}
			}
    ]
  });
  new $.fn.dataTable.FixedHeader(shaperClass);
  }
  
  function initMatch(){
    var shaperMatch = $('#match-table').DataTable({
      processing: true,
      responsive: true,
      serverSide: false,
      ajax: {
        url: 'api/traffic-policy/match.php',
        type: 'POST',
      },
      columns: [
        { data: 'shaperName' },
        { data: 'classId' },
        { data: 'match' },
        { data: 'interface' },
        { data: 'dstIP' },
        { data: 'srcIP' },
        { data: 'description' },
          {
            data: null,
            render: function(data) {
              var rowData = JSON.stringify(data);
              return `<div class="dropdown dropstart">
              <a class="btn btn-icon btn-ghost btn-xs rounded-circle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
              </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="#" onclick='editMatch(${rowData})'>Edit</a></li>
                  <li><a class="dropdown-item" href="#" onclick='deleteMatch(${rowData})'>Delete</a></li>
                </ul>
              </div>`;
            }
          }
      ],
    });
    new $.fn.dataTable.FixedHeader(shaperMatch);
  }

  initShaper();
  loadedData['shaper'] = true;
  $(".nav-link").on("shown.bs.tab", function(e) {
    let targetTabId = $(e.target).attr("aria-controls");
    if (targetTabId === 'nav-nav-shaper') {
    loadDataTable('shaper');
    } else if (targetTabId === 'nav-shaper-class') {
    loadDataTable('class');
    } else if (targetTabId === 'nav-shaper-class-match') {
    loadDataTable('match');
    }
  });
  });

// add Shaper function
function addShaper() {
	Swal.fire({
		title: 'Add Shaper',
		html: `
        <form id="addForm">
            <div class="form-group">
                <input type="text" id="shaperName" class="form-control" placeholder="shaper name">
            </div>
            <br/>
            <div class="form-group">
                <input type="text" id="bandwidth" class="form-control" placeholder="bandwidth: mbit/gbit">
            </div>
            <br/>
            <div class="form-group">
                <input type="text" id="defaultBandwidth" class="form-control" placeholder="default bandwidth: 100%">
            </div>
            <br/>
            <div class="form-group">
                <input type="text" id="defaultBurst" class="form-control" placeholder="default burst: 15k">
            </div>
            <br/>
            <div class="form-group">
                <select id="defaultQueueType" class="form-select">
                    <option value="fq-codel">fq-codel</option>
                    <option value="fair-queue">fair-queue</option>
                    <option value="drop-tail">drop-tail</option>
                    <option value="priority">priority</option>
                    <option value="random-detect">random-detect</option>
                </select>
            </div>
            <br/>
            <div class="form-group">
                <input type="text" id="description" class="form-control" placeholder="description">
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

			const shaperName = $('#shaperName').val();
			const bandwidth = $('#bandwidth').val();
			const defaultBandwidth = $('#defaultBandwidth').val();
			const defaultBurst = $('#defaultBurst').val();
			const defaultQueueType = $('#defaultQueueType').val();
			const description = $('#description').val();


			if (!shaperName || !bandwidth) {
				Swal.showValidationMessage('All fields are required!');
				return false; 
			}


			return $.ajax({
				url: 'api/traffic-policy/shaper_add.php', 
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'add',
					shaperName: shaperName,
					bandwidth: bandwidth,
					defaultBandwidth: defaultBandwidth,
					defaultBurst: defaultBurst,
					defaultQueueType: defaultQueueType,
					description: description
				}
			});
		}
	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Success!', 'New Shaper has been added.', 'success');
	
				$('#shaper-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result); 
			}
		}
	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to add Shaper.', 'error');
		console.error('Failed to add Shaper:', error);
	});
}
function deleteShaper(data) {

	Swal.fire({
		title: "Delete Shaper",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">Shaper -> ${data.shaperName}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/traffic-policy/shaper_delete.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'delete',
					shaperName: data.shaperName
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'Shaper has been deleted.', 'success');
				$('#shaper-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', '<small>' + result.value.message + '</small>', 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete Shaper.', 'error');
		console.error('Failed to delete Shaper:', error);
	});
}
function editShaper(data) {
	Swal.fire({
	  title: 'Edit Shaper',
	  html: `
		<form id="editForm">
		<div class="form-group">
		  <input type="text" id="shaperName" class="mt-3 form-control" value="${data.shaperName}" disabled>
		  <input type="text" id="bandwidth" class="mt-3 form-control" value="${data.bandwidth}">
		  <input type="text" id="defaultBandwidth" class="mt-3 form-control" value="${data.defaultBandwidth}" placeholder="default bandwidth">
		  <input type="text" id="defaultBurst" class="mt-3 form-control" value="${data.defaultBurst}" placeholder="default burst">
		  <select id="defaultQueueType" class="mt-3 form-select">
		  <option value="fq-codel">fq-codel</option>
		  <option value="fair-queue">fair-queue</option>
		  <option value="drop-tail">drop-tail</option>
		  <option value="priority">priority</option>
		  <option value="random-detect">random-detect</option>
		  </select>
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
  

		const shaperName = data.shaperName;
		const bandwidth = data.bandwidth;
		const defaultBandwidth = data.defaultBandwidth;
		const defaultBurst = data.defaultBurst;
		const defaultQueueType = data.defaultQueueType;
		const description = data.description;
  

		const editedShaperName = $('#shaperName').val();
		const editedBandwidth = $('#bandwidth').val();
		const editedDefaultBandwidth = $('#defaultBandwidth').val();
		const editedDefaultBurst = $('#defaultBurst').val();
		const editedDefaultQueueType = $('#defaultQueueType').val();
		const editedDescription = $('#description').val();
  

		if (
		  editedShaperName === shaperName &&
		  editedBandwidth === bandwidth &&
		  editedDefaultBandwidth === defaultBandwidth &&
		  editedDefaultBurst === defaultBurst &&
		  editedDefaultQueueType === defaultQueueType &&
		  editedDescription === description
		) {

		  Swal.fire('No Changes', 'There are no changes to save.', 'info');
		  return false;
		}
  

		return $.ajax({
		  url: 'api/traffic-policy/shaper_edit.php',
		  type: 'POST',
		  dataType: 'json',
		  data: {
			action: 'edit',
			shaperName: editedShaperName,
			bandwidth: editedBandwidth,
			defaultBandwidth: editedDefaultBandwidth,
			defaultBurst: editedDefaultBurst,
			defaultQueueType: editedDefaultQueueType,
			description: editedDescription
		  }
		});
	  }
	}).then(function (result) {
	  if (result.isConfirmed) {
		if (result.value.success) {
		  Swal.fire('Success!', 'Shaper data has been updated.', 'success');

		  console.log('Debug Success:', result);
		  $('#shaper-table').DataTable().ajax.reload();
		} else {
		  Swal.fire('Error!', result.value.message, 'error');
		  console.log('Debug Error:', result);
		}
	  }
	}).catch(function (error) {
	  Swal.fire('Error!', 'Failed to update Shaper data.', 'error');
	  console.error('Failed to update Shaper data:', error);
	});
}

// add class function
function addClass() {
  Swal.fire({
    title: 'Add Class',
    html: `
    <form id="addForm">
    <div class="form-group">
    <select id="shaperName" class="form-select">
    <option value="" disabled selected>Choose Shaper</option>
    </select>
    </div>
    <br/>
    <div class="form-group">
      <input type="number" id="classId" class="form-control" placeholder="class number: 2-4095">
    </div>
    <br/>
      <!--<div class="form-group">
        <input type="text" id="match" class="form-control" placeholder="match name">
      </div>
      <br/>-->
      <div class="form-group">
        <input type="text" id="bandwidth" class="form-control" placeholder="bandwidth: mbit/gbit">
      </div>
      <br/>
      <div class="form-group">
        <input type="text" id="burst" class="form-control" placeholder="burst bandwidth: mbit/gbit">
      </div>
      <br/>
      <div class="form-group">
      <select id="queueType" class="form-select">
          <option value="fq-codel">fq-codel</option>
          <option value="fair-queue">fair-queue</option>
          <option value="drop-tail">drop-tail</option>
          <option value="priority">priority</option>
          <option value="random-detect">random-detect</option>
      </select>
  </div>
      <br/>
      <div class="form-group">
        <input type="text" id="description" class="form-control" placeholder="description">
      </div>
    </form>
  `,
    didOpen: () => {

      function fillSelectOption(data) {
        const selectElement = $('#shaperName');
        selectElement.empty();


        selectElement.append('<option value="" disabled selected>Choose Shaper</option>');


        data.forEach(function(item) {
          selectElement.append(`<option value="${item}">${item}</option>`);
        });
      }


      $.ajax({
        url: 'api/traffic-policy/class_select_option.php',
        type: 'GET',
        dataType: 'json',
        data: {
          action: 'class-select-option'
        },
        success: function(data) {
          fillSelectOption(data);
        },
        error: function(error) {
          console.error('Failed to fetch data from API:', error);
        }
      });
    },
    showCancelButton: true,
    confirmButtonText: 'Save',
    cancelButtonText: 'Cancel',
    showLoaderOnConfirm: true,
    focusConfirm: false,
    allowOutsideClick: false,
    preConfirm: function() {
      const classId = $('#classId').val();
      const shaperName = $('#shaperName').val();
      const bandwidth = $('#bandwidth').val();
      const burst = $('#burst').val();
      // const match = $('#match').val();
      const queueType = $('#queueType').val();
      const description = $('#description').val();


      if (!classId || !shaperName || !bandwidth || !burst || !queueType) {
        Swal.showValidationMessage('All fields are required!');
        return false;
      }

   
      return $.ajax({
        url: 'api/traffic-policy/class_add.php',
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'add',
          classId: classId,
          shaperName: shaperName,
          bandwidth: bandwidth,
          burst: burst,
          // match: match,
          queueType: queueType,
          description: description
        }
      });
    }
  }).then(function(result) {
    if (result.isConfirmed) {
      if (result.value.success) {
        Swal.fire('Success!', result.value.message, 'success');
        console.info('debug success:', result);
        $('#class-table').DataTable().ajax.reload();
      } else {
        Swal.fire('Error!', result.value.message, 'error');
        console.error('debug error:', result);
      }
    }
  }).catch(function(error) {
    Swal.fire('Error!', 'Failed to add Class.', 'error');
    console.error('Failed to add Class:', error);
  });
}
function editClass(data) {
	Swal.fire({
		title: 'Edit Class',
		html: `
      <form id="editForm">
      <div class="form-group">
      <input type="text" id="shaperName" class="mt-3 form-control" value="${data.shaperName}" disabled>
        <input type="text" id="classId" class="mt-3 form-control" value="${data.classId}" disabled>
        <!--<input type="text" id="match" class="mt-3 form-control" value="${data.match}" placeholder="match-name">-->
        <input type="text" id="bandwidth" class="mt-3 form-control" value="${data.bandwidth}" placeholder="bandwidth">
        <input type="text" id="burst" class="mt-3 form-control" value="${data.burst}" placeholder="burst">
        <select id="queueType" class="mt-3 form-select">
          <option value="fq-codel">fq-codel</option>
          <option value="fair-queue">fair-queue</option>
          <option value="drop-tail">drop-tail</option>
          <option value="priority">priority</option>
          <option value="random-detect">random-detect</option>
        </select>
        <input type="text" id="description" class="mt-3 form-control" value="${data.description}" placeholder="Description">
      </div>
      </form>
      `,
		showCancelButton: true,
		confirmButtonText: 'Save',
		cancelButtonText: 'Cancel',
		showLoaderOnConfirm: true,
		focusConfirm: true,
		allowOutsideClick: false,
		preConfirm: function() {


			const shaperName = $('#shaperName').val();
			const classId = $('#classId').val();
			// const match = $('#match').val();
			const bandwidth = $('#bandwidth').val();
			const burst = $('#burst').val();
			const queueType = $('#queueType').val();
			const description = $('#description').val();


      if (
        bandwidth === data.bandwidth &&
        burst === data.burst &&
        queueType === data.queueType &&
        description === data.description
      ) {
        Swal.fire('No Changes', 'There are no changes to save.', 'info');
        return false; 
        }

			return $.ajax({
				url: 'api/traffic-policy/class_edit.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'edit',
					shaperName: shaperName,
					classId: classId,
					bandwidth: bandwidth,
					burst: burst,
					queueType: queueType,
					description: description
				}
			});
		}
	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Success!', 'Class data has been updated.', 'success');

				console.log('Debug Success:', result);
				$('#class-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.log('Debug Error:', result);
			}
		}
	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to update class data.', 'error');
		console.error('Failed to update class data:', error);
	});
}
function deleteClass(data) {

	Swal.fire({
		title: "Delete Class",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">${data.shaperName} -> ClassID -> ${data.classId}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/traffic-policy/class_delete.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'delete',
					shaperName: data.shaperName,
					classId: data.classId
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'Class has been deleted.', 'success');
				$('#class-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete Class.', 'error');
		console.error('Failed to delete Class:', error);
	});
}

// add match function
function addMatch() {
  Swal.fire({
    title: 'Add Match',
    html: `
      <form id="addForm">
        <div class="form-group">
            <select id="shaperName" class="form-select">
                <option value="" disabled selected>Choose Shaper</option>
            </select>
        </div>
        <br/>
        <div class="form-group">
            <select id="classId" class="form-select">
                <option value="" disabled selected>Choose Class</option>
            </select>
        </div>
        <br/>
        <div class="form-group">
          <input type="text" id="match" class="form-control" placeholder="match name">
        </div>
        <br/>
        <div class="form-group">
          <input type="text" id="interface" class="form-control" placeholder="interface name">
        </div>
        <br/>
        <div class="form-group">
          <input type="text" id="dstIP" class="form-control" placeholder="destination IP">
        </div>
        <br/>
        <div class="form-group">
          <input type="text" id="srcIP" class="form-control" placeholder="source IP">
        </div>
        <br/>
        <div class="form-group">
          <input type="text" id="description" class="form-control" placeholder="description">
        </div>
      </form>
    `,
    didOpen: () => {

        function fillSelectOption(data, selectElement) {
          selectElement.empty();
          selectElement.append('<option value="" disabled selected>Choose Shaper</option>');

          $.each(data, function(shaperName, shaper) {
              selectElement.append(`<option value="${shaperName}">${shaperName}</option>`);
          });
      }

      function fillClassOption(shaperName, selectElement) {
          selectElement.empty();
          selectElement.append('<option value="" disabled selected>Choose Class</option>');

          $.ajax({
              url: 'api/traffic-policy/shaper_select_class.php',
              type: 'POST',
              dataType: 'json',
              data: { shaperName: shaperName },
              success: function(data) {

                  $.each(data, function(classId, classData) {
                      selectElement.append(`<option value="${classId}">Class ${classId}</option>`);
                  });
              },
              error: function(error) {
                  console.error('Failed to fetch data from API:', error);
              }
          });
      }

      $.ajax({
          url: 'api/traffic-policy/shaper_select.php',
          type: 'POST',
          dataType: 'json',
          success: function(data) {
              fillSelectOption(data, $('#shaperName'));
          },
          error: function(error) {
              console.error('Failed to fetch data from API:', error);
          }
      });

      $('#shaperName').on('change', function() {
          const selectedShaper = $(this).val();
          if (selectedShaper) {
              fillClassOption(selectedShaper, $('#classId'));
          } else {
              $('#classId').empty();
              $('#classId').append('<option value="" disabled selected>Choose Class</option>');
          }
      });
    },
    showCancelButton: true,
    confirmButtonText: 'Save',
    cancelButtonText: 'Cancel',
    showLoaderOnConfirm: true,
    focusConfirm: false,
    allowOutsideClick: false,
    preConfirm: function() {

      const shaperName = $('#shaperName').val();
      const classId = $('#classId').val();
      const match = $('#match').val();
      const interface = $('#interface').val();
      const dstIP = $('#dstIP').val();
      const srcIP = $('#srcIP').val();
      const description = $('#description').val();


      if (!shaperName || !classId || !match) {
        Swal.showValidationMessage('All fields are required!');
        return false;
      }

      return $.ajax({
        url: 'api/traffic-policy/match_add.php',
        type: 'POST',
        dataType: 'json',
        data: {
          action: 'add',
          shaperName: shaperName,
          classId: classId,
          match: match,
          interface: interface,
          dstIP: dstIP,
          srcIP: srcIP,
          description: description
        }
      });
    }
  }).then(function(result) {
    if (result.isConfirmed) {
      if (result.value.success) {
        Swal.fire('Success!', result.value.message, 'success');
        console.info('debug success:', result);
        $('#match-table').DataTable().ajax.reload();
      } else {
        Swal.fire('Error!', result.value.message, 'error');
        console.error('debug error:', result);
      }
    }
  }).catch(function(error) {
    Swal.fire('Error!', 'Failed to add Match.', 'error');
    console.error('Failed to add Match:', error);
  });
}
function editMatch(data) {
	Swal.fire({
		title: 'Edit Match',
		html: `
      <form id="editForm">
      <div class="form-group">
      <input type="text" id="shaperName" class="mt-3 form-control" value="${data.shaperName}" disabled>
        <input type="text" id="classId" class="mt-3 form-control" value="${data.classId}" disabled>
        <input type="text" id="match" class="mt-3 form-control" value="${data.match}" disabled>
        <input type="text" id="interface" class="mt-3 form-control" value="${data.interface}" placeholder="interface">
        <input type="text" id="dstIP" class="mt-3 form-control" value="${data.dstIP}" placeholder="destination IP">
        <input type="text" id="srcIP" class="mt-3 form-control" value="${data.srcIP}" placeholder="source IP">
        <input type="text" id="description" class="mt-3 form-control" value="${data.description}" placeholder="Description">
      </div>
      </form>
      `,
		showCancelButton: true,
		confirmButtonText: 'Save',
		cancelButtonText: 'Cancel',
		showLoaderOnConfirm: true,
		focusConfirm: true,
		allowOutsideClick: false,
		preConfirm: function() {


			const shaperName = $('#shaperName').val();
			const classId = $('#classId').val();
			const match = $('#match').val();
			const interface = $('#interface').val();
			const dstIP = $('#dstIP').val();
			const srcIP = $('#srcIP').val();
			const description = $('#description').val();


      if (
        interface === data.interface &&
        dstIP === data.dstIP &&
        srcIP === data.srcIP &&
        description === data.description
      ) {
		  Swal.fire('No Changes', 'There are no changes to save.', 'info');
		  return false;
		  }
      
			return $.ajax({
				url: 'api/traffic-policy/match_edit.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'edit',
					shaperName: shaperName,
					classId: classId,
					match: match,
					interface: interface,
					dstIP: dstIP,
					srcIP: srcIP,
					description: description
				}
			});
		}
  }).then(function(result) {
    if (result.isConfirmed) {
      if (result.value.success) {
        Swal.fire('Success!', result.value.message, 'success');
        console.info('debug success:', result);
        $('#match-table').DataTable().ajax.reload();
      } else {
        Swal.fire('Error!', result.value.message, 'error');
        console.error('debug error:', result);
      }
    }
  }).catch(function(error) {
    Swal.fire('Error!', 'Failed to edit Match.', 'error');
    console.error('Failed to edit Match:', error);
  });
}
function deleteMatch(data) {

	Swal.fire({
		title: "Delete Match",
		html: `Are you sure you want to delete?<br><br><small style="font-weight:bold;">Match -> ${data.match}</small>`,
		icon: "warning",
		confirmButtonText: "Delete",
		showCancelButton: true,
		showLoaderOnConfirm: true,
		allowOutsideClick: true,
		backdrop: true,
		preConfirm: function() {
			return $.ajax({
				url: 'api/traffic-policy/class_delete.php',
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'delete',
					shaperName: data.shaperName,
					classId: data.classId,
					match: data.match
				}
			});
		},

	}).then(function(result) {
		if (result.isConfirmed) {
			if (result.value.success) {
				Swal.fire('Deleted!', 'Match has been deleted.', 'success');
				$('#match-table').DataTable().ajax.reload();
			} else {
				Swal.fire('Error!', result.value.message, 'error');
				console.error('error:', result);
			}
		}

	}).catch(function(error) {
		Swal.fire('Error!', 'Failed to delete Match.', 'error');
		console.error('Failed to delete Match:', error);
	});
}