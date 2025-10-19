function submitLogin() {
    event.preventDefault();
    const username = jQuery('#login-username').val();
    const password = jQuery('#login-password').val();

    let errors = validateLoginForm(username, password);

    if (errors.length > 0) {
        handleError(errors.join('\n'));
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
        url: '/CONF/public/api/login_page/login.php',
        type: 'POST',
        dataType: 'json',
        data: {
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
                        window.location.href = '/CONF/';
                    }, 1000);
                }
                else {
                    handleError(response.message);
                }
        },
        error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                handleError('An error occurred, try again.');
        }
    });
}

function handleError(message) {
    $('#message').addClass('alert alert-danger');
    $('#message').text(message);
}

function changeToLogin() {
    $('#login-form').show();
    $('#register-form').hide();
    $('#message').removeClass('alert alert-danger alert-success').text('');
}