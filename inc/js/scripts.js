$(function() {

  // Initialize tooltipster on signin-form input/password elements
  $('.signin-form input[type="email"], .signin-form input[type="password"]').tooltipster({ 
    animation: 'grow',
    trigger: 'custom', // default is 'hover' which is no good here
    onlyOne: false,    // allow multiple tips to be open at a time
    position: 'right'  // display the tips to the right of the element
  });

  $(".signin-form").validate({
    rules: {
      'email-SI': {
        required: true,
        minlength: 5,
        remote: {
          url: "../valid_email.php",
          type: "POST" 
        } 
      },
      'password-SI': {
        required: true,
        remote: {
          url: "../valid_password.php",
          type: "POST",
          data: {
            'email-SI': function() {
              return $("#email-SI").val();
            }
          }
        } 
      }
    },  
    messages: {
      'email-SI': {
        required: "Email Required",
        minlength: "5 Characters Required",
        remote: "Invalid Email."     
      },
      'password-SI': {
        required: "Password Required",
        remote: "Invalid Password."
      }
    },
    errorPlacement: function (error, element) {
      $(element).tooltipster('update', $(error).text());
      $(element).tooltipster('show');
      $('#signIn').on('hidden.bs.modal', function () {
        $(element).tooltipster('hide');
      });
    },
    success: function (label, element) {
      $(element).tooltipster('hide');
    }
  });

  // Initialize tooltipster on signup-form input/password elements
  $('.signup-form input[type="email"], .signup-form input[type="text"], .signup-form input[type="password"]').tooltipster({ 
    animation: 'grow',
    trigger: 'custom', // default is 'hover' which is no good here
    onlyOne: false,    // allow multiple tips to be open at a time
    position: 'right'  // display the tips to the right of the element
  });

  $(".signup-form").validate({
    rules: {
      email: {
        required: true,
        remote: {
          url: "../check_email.php",
          type: "POST" 
        } 
      },
      username: {
        required: true,
        minlength: 6,
        remote: {
          url: "../check_username.php",
          type: "POST"
        }
      },
      password: {
        required: true,
        minlength: 6
      }
    },  
    messages: {
      email: {
        required: "Email Required",
        remote: "This Email Already Exists"      
      },
      username: {
        required: "Username Required",
        minlength: "6 Characters Required",
        remote: "This Username Already Exists"
      },
      password: {
        required: "Password Required",
        minlength: "6 Characters Required"
      },
    },
    errorPlacement: function (error, element) {
      $(element).tooltipster('update', $(error).text());
      $(element).tooltipster('show');
      $('#getStarted').on('hidden.bs.modal', function () {
       $(element).tooltipster('hide');
      });
    },
    success: function (label, element) {
      $(element).tooltipster('hide');
    }
  });
});