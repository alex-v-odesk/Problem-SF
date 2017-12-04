jQuery(document).ready(function($) {
    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e) {
        thisForm = $(this);
        thisForm.find('input.btn').attr('value', '').addClass('processing');
        thisForm.find('.status').show().text('Logging In...').removeClass('error');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': thisForm.find('#username').val(),
                'password': thisForm.find('#password').val(),
                'security': thisForm.find('#security').val()
            },
            success: function(data) {
                thisForm.find('.status').text(data.message).removeClass('error');
                console.log(data);
                if (data.loggedin === true) {
                    thisForm.find('input.btn').removeClass('processing').addClass('success').attr('value', 'Success!');
                    document.location.href = ajax_login_object.redirecturl;
                }
                if (data.loggedin !== true) {
                    console.log(data.loggedin);
                    console.log(thisForm);
                    thisForm.find('input.btn').removeClass('processing').attr('value', 'Try Again');
                    $(this).find('.status').addClass('error');
                }
            }
        });
        e.preventDefault();
    });
    $('form#register').on('submit', function(e) {
        thisForm = $(this);
        // Show 'Please wait' loader to user, so she/he knows something is going on
        thisForm.find('input.button').attr('value', '').addClass('processing');
        thisForm.find('.status').text('Registering...');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'register_user', //calls wp_ajax_nopriv_ajaxlogin
                'password': thisForm.find('#reg_password').val(),
                'security': thisForm.find('#register-security').val(),
                'email': thisForm.find('#reg_email').val()
            },
            success: function(data) {
                thisForm.find('.status').text(data.message).removeClass('error');
                if (data.registered === true) {
                    thisForm.find('input.btn').removeClass('processing').addClass('success').attr('value', 'Success!');
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajax_login_object.ajaxurl,
                        data: {
                            'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                            'username': thisForm.find('#reg_email').val(),
                            'password': thisForm.find('#reg_password').val(),
                            'security': $('form#login #security').val()
                        },
                        success: function(data) {
                            thisForm.find('.status').text(data.message).removeClass('error');
                            if (data.loggedin === true) {
                                thisForm.find('input.btn').removeClass('processing').addClass('success').attr('value', 'Success!');
                                document.location.href = ajax_login_object.redirecturl;
                            }
                            if (data.loggedin !== true) {
                                thisForm.find('input.button').removeClass('processing').attr('value', 'Try Again');
                                thisForm.find('.status').addClass('error');
                            }
                        }
                    });
                }
                if (data.registered !== true) {
                    thisForm.find('input.button').removeClass('processing').attr('value', 'Try Again');
                    thisForm.find('.status').addClass('error');
                }
            }
        });
        e.preventDefault();
    });
});