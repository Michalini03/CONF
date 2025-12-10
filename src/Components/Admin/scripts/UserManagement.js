const USER_SECTION_ID = '#user-list';
const ADMIN_SECTION_ID = '#admin-list';
const ADMIN_API_URL = '/public/api/api_admin.php';

const RIGHTS_MAP = {
    1: 'Author',
    2: 'Reviewer',
    3: 'Admin',
};

var ALLOWED_RIGHTS_MAP = null;

function setupRightsMap(userAccessRights) {
    // This function can be expanded if dynamic rights mapping is needed in the future
    ALLOWED_RIGHTS_MAP = {};
    for (var key in RIGHTS_MAP) {
        if (parseInt(key) < userAccessRights) {
            ALLOWED_RIGHTS_MAP[key] = RIGHTS_MAP[key];
        }
    }
}

/**
 * A reusable function to load data from the admin API.
 *
 * @param {string} action - The API action ('fetchUsers' or 'fetchAdmins').
 * @param {string} targetSectionId - The HTML ID where the data should be displayed.
 */
function loadAdminData(action, targetSectionId) {
    $.ajax({
        // 1. Use your new single API file
        url: ADMIN_API_URL, 
        type: 'GET',
        dataType: 'json',
        // 2. Pass the 'action' as a query parameter
        data: {
            action: action 
        },
        success: function(response) {
            if (response.success) {
                var dataList = response.data;
                // 3. Use the targetSectionId to display the data
                displayData(dataList, targetSectionId); 
            } else {
                console.error('Error fetching ' + action + ':', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error for ' + action + ':', error);
        }
    });
}

function loadUsers() {
    loadAdminData('fetchUsers', USER_SECTION_ID);
}

function loadAdmins() {
    loadAdminData('fetchAdmins', ADMIN_SECTION_ID);
}

function displayData(data, sectionId = USER_SECTION_ID) {
    var $section = $(sectionId);
    $section.empty();

    if(!data || data.length == 0) {
        return;
    }

    var $wrapper = $('<div class="table-responsive"></div>');
    var $table = $('<table class="table table-hover table-striped table-dark table-responsive"></table>');
    var $thead = $('<thead><tr><th>ID</th><th>Username</th><th>Access Rights</th><th></th></tr></thead>');
    var $tbody = $('<tbody></tbody>');

      data.forEach(function(dataItem) {
            var $row = $('<tr id="user-'+dataItem.id+'"></tr>');
            $row.append('<td>' + dataItem.id + '</td>');
            $row.append('<td>' + dataItem.username + '</td>');

            var $rightsSelect = $('<select class="form-select form-select-sm"></select>');
            for (var key in RIGHTS_MAP) {
                var $option = $('<option></option>')
                    .attr('value', key)
                    .text(RIGHTS_MAP[key]);
                if (parseInt(dataItem.access_rights) === parseInt(key)) {
                    $option.attr('selected', 'selected');
                }
                $rightsSelect.append($option);
            }
            $row.append($('<td></td>').append($rightsSelect));

            var $saveButton = $('<button class="btn btn-sm btn-primary">Save</button>');
            $saveButton.on('click', function() {
                var newRights = $rightsSelect.val();
                updateUserRights(dataItem.id, newRights);
            });
            var $deleteButton = $('<button class="btn btn-sm btn-danger ms-2">Delete</button>');
            $deleteButton.on('click', function() {
                deleteUser(dataItem.id);
            });
            var $actionTd = $('<td style="align: left"></td>').append($saveButton).append($deleteButton);
            $row.append($actionTd);

            $tbody.append($row);


      }
    );

    $table.append($thead);
    $table.append($tbody);
    $wrapper.append($table)
    $section.append($wrapper);
}

function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user?')) {
        return; 
    }

    $.ajax({
        url: ADMIN_API_URL, 
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'deleteUser', 
            user_id: userId 
        },
        success: function(response) {
            if (response.success) {
                alert('User deleted successfully.');
                $(document).trigger('ready');
            } else {
                // Show the error from the server
                console.error('Error deleting user:', response.message);
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error for deleteUser:', error);
        }
    });
}

function updateUserRights(userId, newRights) {
    $.ajax({
        url: ADMIN_API_URL, 
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'updateUserRights', 
            user_id: userId,
            access_rights: newRights
        },
        success: function(response) {
            if (response.success) {
                alert('User rights updated successfully.');
                $(document).trigger('ready');
            } else {
                console.error('Error updating user rights:', response.message);
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error for updateUserRights:', error);
        }
    });
}