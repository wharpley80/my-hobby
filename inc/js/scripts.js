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

  // Initialize tooltipster on add_gallery input/select elements
  $('#gallery-form input[type="text"], #gallery-form select, #gallery-form input[type=radio]').tooltipster({ 
    animation: 'grow',
    trigger: 'custom', // default is 'hover' which is no good here
    onlyOne: false,    // allow multiple tips to be open at a time
    position: 'top'  // display the tips to the right of the element
  });

  $("#gallery-form").validate({
    rules: {
      'new-gallery': {
        required: true,
        remote: {
          url: "../check_galleryname.php",
          type: "POST"
        }
      },
      'gallery-type': {
        required: true
      },
      optionsRadios: {
        required: true
      }
    },  
    messages: {
      'new-gallery': {
        required: "Please Name New Gallery",
        remote: "Choose A Unique Gallery Name"
      },
      'gallery-type': {
        required: "Please Select A Gallery Type"
      },
      optionsRadios: {
        required: "Please Select A Privacy"
      }
    },
    errorPlacement: function (error, element) {
      $(element).tooltipster('update', $(error).text());
      $(element).tooltipster('show');
    },
    success: function (label, element) {
      $(element).tooltipster('hide');
    }
  });

  // Initialize tooltipster on upload-form input elements
  $('#upload-form input[type="file"], #upload-form input[type="text"], #upload-form textarea').tooltipster({ 
    animation: 'grow',
    trigger: 'custom', // default is 'hover' which is no good here
    onlyOne: false,    // allow multiple tips to be open at a time
    position: 'right'  // display the tips to the right of the element
  });

  $("#upload-form").validate({
    rules: {
      image: {
        required: true
      },
      'image-name': {
        required: true,
        remote: {
          url: "../check_imagename.php",
          type: "POST"
        }
      }
    },  
    messages: {
      image: {
        required: "Please Select Image"
      },
      'image-name': {
        required: "Please Name Image",
        remote: "This Image Name Already Exists"
      }
    },
    errorPlacement: function (error, element) {
      $(element).tooltipster('update', $(error).text());
      $(element).tooltipster('show');
      $('#upload').on('hidden.bs.modal', function () {
       $(element).tooltipster('hide');
      });
    },
    success: function (label, element) {
      $(element).tooltipster('hide');
    }
  });

  // Progress Bar
  /*
  $(function() {
    $('#upload-form').ajaxForm({
      beforeSend:function(){
        $(".progress").show();
      },
      uploadProgress:function(event,position,total,percentComplete){
        $('.progress-bar').width(percentComplete+ '%');
        $('.sr-only').html(percentComplete+ '%');
      },
      success:function(){
       // window.location.href = '../collection/';
       window.location.reload(true);
      }
    });
    $(".progress").hide();
  });
*/

  // Enlarges Image in Modal Window
  $('.show-img').on('click', function(event) {
    event.preventDefault();
    
    var id = $(this).parent('a').find('span').data('id');
    
    $('#imagepreview').attr('src', $('#imageresource' + id).attr('src'));
    $('#imagemodal').modal('show'); 

    $.ajax({
      type: "POST",
      url: "../modal_name.php",
      data: {
        id: id
      },
      success: function(data) {
        $('#title-name').text(data);
      }
    });
  });

  // Likes Image
  $('.like-img').on('click', function(event) {
    event.preventDefault();
  
    var id = $(this).find('span').data('id');

    $.ajax({
      type: "POST",
      url: "../like_image.php",
      data: {
        id: id
      },
      success: function(data) {
        if (data == "success")  {
          like_get(id);
        }
      } 
    });
    function like_get(id) {
      $.ajax({
        type: "POST",
        url: "../liked_image.php",
        data: {
          id: id
        },
        success: function(data) {
          $('#liked_' + id + '_likes').text(data);
        }
      });
    }
  });

  // Modal Title
  $('.show-img').on('click', function(event) {
    event.preventDefault();
  
    var id = $(this).parent('a').find('span').data('id');
    
    $.ajax({
      type: "POST",
      url: "../modal_name.php",
      data: {
        id: id
      },

      success: function(data) {
        $('#title-name').text(data);
      }

    });
    // Edit Image Name
    $('#change-name').on('click', function(event) {
      event.preventDefault();

      var name = $('#new-name').val(); 

      function edit_name(id,name) {
        $.ajax({
          type: "POST",
          url: "../edit_name.php",
          data: {
            id: id,
            name: name
          },

          success: function(data) {
            $('#title-name').text(data);
            $('#edited_' + id + '_name').text(data);
            location.reload();
          }
        });
      }
      edit_name(id,name);
    });
  });

  // Modal Description
  $('.show-img').on('click', function(event) {
    event.preventDefault();
  
    var id = $(this).parent('a').find('span').data('id');

    $.ajax({
      type: "POST",
      url: "../modal_description.php",
      data: {
        id: id
      },
      success: function(data) {
        $('#modal-description').text(data);
      }
    });
    // Edit Image Description
    $('#change-description').on('click', function(event) {
      event.preventDefault();
      var description = $('#new-description').val(); 

      function edit_description(id,description) {
        $.ajax({
          type: "POST",
          url: "../edit_description.php",
          data: {
            id: id,
            description: description
          },
          success: function(data) {
            $('#modal-description').text(data);
            $('#edited_' + id + '_description').text(data);
            location.reload();
          }
        });
      }
      edit_description(id,description);
    });
  });

  // Viewed Count
  $('.view-img').on('click', function(event) {
    event.preventDefault();
  
    var id = $(this).find('span').data('id');
    $('#imagepreview').attr('src', $('#imageresource' + id).attr('src'));
    $('#imagemodal').modal('show'); 

    $.ajax({
      type: "POST",
      url: "../view_image.php",
      data: {
        id: id
      },
      success: function(data) {
        if (data == "success")  {
          view_get(id);
        }
      } 
    });
    function view_get(id) {
      $.ajax({
        type: "POST",
        url: "../viewed_image.php",
        data: {
          id: id
        },
        success: function(data) {
          $('#viewed_' + id + '_views').text(data);
        }
      });
    }
  });

  //Rotates Image
  $('.rotate-img').on('click', function(event) {
    event.preventDefault();
  
    var id = $(this).find('span').data('id');

    $.ajax({
      type: "POST",
      url: "../rotate_image.php",
      data: {
        id: id
      },

      success: function(data) {
        if (data == "success")  {
          rotate_get(id);
        }
      }
    });
    function rotate_get(id) {
      $.ajax({
        type: "POST",
        url: "../rotated_image.php",
        data: {
          id: id
        },
        success: function(data) {
          $('#imageresource' + id).attr('src', 'data:image;base64,' + data);
        }
      });
    }
  });

  // Removes a Image from Gallery
  $('a.delete-img').on('click', function(event) {
    event.preventDefault();
    
    if (confirm("Are you sure you want to delete this image?")) {
      var parent = $(this).closest('div');
      var id = $(this).find('span').data('id');
      var id = parent.find('span').data('id');
      parent.fadeOut();
     
      $.ajax({
        type: "POST",
        url: "../delete_img.php",
        data: {
          id: id
        },
      });
    }
  });  

  // Deletes a Specific Gallery
  $(function() {
    $('a#delete-gallery').on('click', function(event) {
      event.preventDefault();
    
      if (confirm("Are you sure you want to delete this Gallery?")) {
        var user = $('#name').closest('div');
        var id = user.find('span').data('id');
        var remove = $('.gallery-name').closest('div');
        var gal = remove.find('span').data('gal');

        $.ajax({
          type: "POST",
          url: "../delete_gallery.php",
          data: {
            id: id,
            gal: gal
          },
          success: function() {
            window.location.href = '../collection/';
          }
        });
      }
    });
  });
});