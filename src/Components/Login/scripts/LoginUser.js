const API_LOGIN_URL = '/public/api/api_login.php';

function submitLogin() {
    event.preventDefault();
    const username = jQuery('#login-username').val();
    const password = jQuery('#login-password').val();

    let errors = validateLoginForm(username, password);

    if (errors.length > 0) {
        handleError(errors);
        return;
    }

    checkIntoDatabase(username, password);
}

function validateLoginForm(username, password) {
    const errors = [];
    if (!username || username.trim() === '') {
        errors.push('Username is required.');
    }
    if (!password || password.trim() === '') {
        errors.push('Password is required.');
    }

    return errors;
}

function checkIntoDatabase(username, password) {
    $.ajax({
        url:  API_LOGIN_URL,
        type: 'POST',
        dataType: 'json',
        data: {
                action: 'login',
                username: username,
                password: password
        },
        success: function(response) {
                if (response.success) {
                    $('#message')
                        .removeClass('alert alert-danger')
                        .addClass('alert alert-success')
                        .text('Login successful!');

                    setTimeout(function() {
                        window.location.href = '/';
                    }, 1000);
                }
                else {
                    handleError([...response.message]);
                }
        },
        error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                handleError([...'An error occurred, try again.']);
        }
    });
}

function handleError(messages) {
    var $messageDiv = $('#message')
    $messageDiv.empty();
    
    messages.forEach(message => {
        var $errorDiv = $('<div></div>');
        $errorDiv.addClass('alert alert-danger');
        $errorDiv.text(message);
        $messageDiv.append($errorDiv)
    });
}

function changeToLogin() {
    $('#login-form').show();
    $('#login-password').val('');
    $('#login-username').val('');
    $('#register-form').hide();
    $('#message').removeClass('alert alert-danger alert-success').text('');
}