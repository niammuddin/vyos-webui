$(document).ready(function() {
    let loadedData = {};
    function loadDataTable(tabId) {
      if (tabId === 'prefix-list' && !loadedData[tabId]) {
        initAspath();
      loadedData[tabId] = true;
      } else if (tabId === 'rule' && !loadedData[tabId]) {
        initRule();
      loadedData[tabId] = true;
      }
    }
  
    function initPrefixList(){
      var prefixListTable = $('#prefix-list-table').DataTable({
        processing: true,
        responsive: true,
        serverSide: false,
        ajax: {
          url: 'api/policy/prefix_list.php',
          type: 'POST',
          data: {
            action: 'prefix-list'
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
      new $.fn.dataTable.FixedHeader(prefixListTable);
    }
  
    function initRule() {
        var ruleTable = $('#rule-table').DataTable({
            processing: true,
            responsive: true,
            serverSide: false,
            ajax: {
                url: 'api/policy/prefix_list.php',
                type: 'POST',
                data: {
                action: 'rule-table'
            }
            },
            columns: [
                {data: 'listName'},
                {data: 'ruleNumber'},
                {data: 'action'},
                {data: 'prefix'},
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
        new $.fn.dataTable.FixedHeader(ruleTable);
    }
    
  
    initPrefixList();
    loadedData['prefix-list'] = true;
    $(".nav-link").on("shown.bs.tab", function(e) {
      let targetTabId = $(e.target).attr("aria-controls");
      if (targetTabId === 'nav-prefix-list-list') {
      loadDataTable('prefix-list');
      } else if (targetTabId === 'nav-rule') {
      loadDataTable('rule');
      }
    });
    });
  