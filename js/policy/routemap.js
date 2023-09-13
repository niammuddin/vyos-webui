$(document).ready(function() {
    let loadedData = {};
    function loadDataTable(tabId) {
      if (tabId === 'routemap' && !loadedData[tabId]) {
        initRoutemap();
      loadedData[tabId] = true;
      } else if (tabId === 'rule' && !loadedData[tabId]) {
        initRule();
      loadedData[tabId] = true;
      } else if (tabId === 'match' && !loadedData[tabId]) {
        initMatch();
      loadedData[tabId] = true;
      } else if (tabId === 'set' && !loadedData[tabId]) {
        initSet();
      loadedData[tabId] = true;
      }
    }
  
    function initRoutemap(){
      var routemapTable = $('#routemap-table').DataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        ajax: {
          url: 'api/policy/routemap.php',
          type: 'POST',
          data: {
            action: 'routemap'
        }
        },
        columns: [
          {data: 'listName'},
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
      new $.fn.dataTable.FixedHeader(routemapTable);
    }
  
    function initRule() {
      var ruleTable = $('#rule-table').DataTable({
      processing: true,
      responsive: true,
      serverSide: false,
      ajax: {
        url: 'api/policy/routemap.php',
        type: 'POST',
        data: {
          action: 'rule-table'
      }
      },
      columns: [
        { data: 'listName' },
        { data: 'ruleNumber' },
        { data: 'action' },
        { data: 'match' },
        { data: 'set' },
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
    new $.fn.dataTable.FixedHeader(ruleTable);
    }
    
    function initMatch(){
      var matchTable = $('#match-table').DataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        ajax: {
          url: 'api/policy/routemap.php',
          type: 'POST',
          data: {
            action: 'match-table'
        }
        },
        columns: [
          { data: 'listName' },
          { data: 'ruleNumber' },
          { data: 'match' },
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
      new $.fn.dataTable.FixedHeader(matchTable);
    }

    function initSet(){
      var setTable = $('#set-table').DataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        ajax: {
          url: 'api/policy/routemap.php',
          type: 'POST',
          data: {
            action: 'set-table'
        }
        },
        columns: [
          { data: 'listName' },
          { data: 'ruleNumber' },
          { data: 'set' },
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
      new $.fn.dataTable.FixedHeader(setTable);
    }
  
    initRoutemap();
    loadedData['routemap'] = true;
    $(".nav-link").on("shown.bs.tab", function(e) {
      let targetTabId = $(e.target).attr("aria-controls");
      if (targetTabId === 'nav-routemap') {
      loadDataTable('routemap');
      } else if (targetTabId === 'nav-rule') {
      loadDataTable('rule');
      } else if (targetTabId === 'nav-match') {
      loadDataTable('match');
      } else if (targetTabId === 'nav-set') {
      loadDataTable('set');
      }
    });
    });