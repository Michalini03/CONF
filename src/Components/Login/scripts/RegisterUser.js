function changeToRegister() {
      $('#login-form').hide();
      $('#register-form').show();
      $('#message').removeClass('alert alert-danger alert-success').text('');
}

function validUserInfo(username, password, confirmPassword) {
      var errors = [];
      if (!username || username.trim() === '') {
            errors.push("Username is required.");
      }
      else if (username.length < 5) {
            errors.push("Username must be at least 5 characters long.");
      }          

      if (!password || password.trim() === '') {
            errors.push("Password is required.");
      }
      else if (password.length < 8) {
            errors.push("Password must be at least 8 characters long.");
      }

      if (!confirmPassword || confirmPassword.trim() === '') {
            errors.push("Confirm Password is required.");
      }
      else if (password !== confirmPassword) {
            errors.push("Passwords do not match.");
      }

      return errors;
}

function submitRegistration(event) {
      event.preventDefault();

      const username = $('#register-username').val();
      const password = $('#register-password').val();
      const confirmPassword = $('#register-confirm-password').val();

      console.log("Registering user:", username);

      let errors = validUserInfo(username, password, confirmPassword)
      console.log("Validation errors:", errors);
      if (errors.length > 0) {
            handleError(errors.join('\n'));
            return;
      }

      $.ajax({
            url: '/CONF/public/api/login_page/register.php',
            type: 'POST',
            data: { username: username, password: password },
            dataType: 'json',
            success: function(response) {
                  if (response.success) {
                        $('#message')
                              .removeClass('alert alert-danger')
                              .addClass('alert alert-success')
                              .text('Registration successful! Please log in.');
                        setTimeout(function() {
                              changeToLogin();
                        }, 1000);
                  }
                  else {
                        handleError(response.message);
                  }
            },
            error: function(xhr, status, error) {
                  alert("Registration failed: " + xhr.responseText);
            }
      });
}