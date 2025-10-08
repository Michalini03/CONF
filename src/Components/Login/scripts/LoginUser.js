function submitLogin() {
      const username = jQuery('#login-username').val();
      const password = jQuery('#login-password').val();

      validateLoginForm(username, password);

      console.log('Username:', username);
      console.log('Password:', password);

      return false; 
}

function validateLoginForm(username, password) {
      const errors = [];
      if (!username || username.trim() === '') {
            errors.push('Username is required.');
      }
      if (!password || password.trim() === '') {
            errors.push('Password is required.');
      }

      if (errors.length > 0) {
            alert(errors.join('\n'));
      }
}