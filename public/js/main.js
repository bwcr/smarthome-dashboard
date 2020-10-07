$(document).ready(function() {
    function removeWarning() {
        if ($('.invalid-feedback,.is-invalid').length) {
            $('.invalid-feedback').remove();
            $('.is-invalid').removeClass('is-invalid');
        }
    }

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 2000);

    $(function() {
        $('.sortable').sortable({
            placeholder: "ui-state-highlight"
        });
    })

    $('form button').attr('disabled', true)

    $('form').on('change', function() {
        $(this).find("button").removeAttr('disabled');
        // $('form button').removeAttr('disabled')
        console.log($('#deviceName').text());
        console.log($('#deviceType').children("option:selected").val())
        switch ($('#deviceType').children("option:selected").val()) {
            case 'Garden':
                $('#deviceName').html('Garden');
                break;
            case 'Lamp':
                $('#deviceName').html('Lamp');
                break;
            case 'Temp':
                $('#deviceName').html('Temp');
                break;
            case 'Door':
                $('#deviceName').html('Door');
                break;
            default:
                break;
        }
    })

    //Loading Button
    $("form").submit(function(e) {
        console.log('loading button');
        e.preventDefault;
        var form = $(this).find('.btn');
        localStorage.setItem("buttonText", form.html());
        var buttonLoading = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        form.html(buttonLoading);
        form.attr('disabled', 'disabled');
    });

    function restoreButton() {
        console.log('button restore');
        $('form .btn').html(localStorage.getItem("buttonText")).removeAttr('disabled');
    }


    // $("#registerForm").submit(function(e) {
    //     e.preventDefault();
    //     removeWarning();

    //     var firstName = document.getElementById('first_name').value;
    //     var lastName = document.getElementById('last_name').value;
    //     var email = document.getElementById('email').value;
    //     var pass = document.getElementById('password').value;
    //     var confirmPass = document.getElementById('password-confirm').value;

    //     if (pass != confirmPass) {
    //         var errorMessage = 'Password do not match';
    //         var errorElement = `<span class="invalid-feedback"><strong>${errorMessage}</strong></span>`;
    //         $("#registerForm #password").addClass(function() {
    //             $(this).after(errorElement);
    //             return "is-invalid";
    //         });
    //         restoreButton();
    //         return false;
    //     }

    //     firebase.auth().createUserWithEmailAndPassword(email, pass).then(function(response) {
    //         var userId = firebase.auth().currentUser.uid;
    //         localStorage.setItem("userId", userId);
    //         console.log("Signed Up!");
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
    //         console.log('ajax');
    //         $.ajax({
    //             type: "POST",
    //             url: "/create",
    //             dataType: "JSON",
    //             data: {
    //                 userId: localStorage.getItem('userId'),
    //                 first_name: firstName,
    //                 last_name: lastName,
    //                 email: email,
    //                 password: pass
    //             },
    //             success: function() {
    //                 restoreButton();
    //                 firebase.auth().signOut();
    //                 console.log('AJAX Success');
    //                 window.location.href = '/login';
    //             },
    //             error: function() {
    //                 console.error();
    //             }
    //         }).done(function() {
    //             console.log("ajax done function");
    //             window.location.href = '/login';
    //         });
    //         window.location.href = '/login';
    //         console.error();
    //     }).catch(function(error) {
    //         var errorCode = error.code;
    //         var errorMessage = error.message;
    //         var errorElement = `<span class="invalid-feedback"><strong>${errorMessage}</strong></span>`;
    //         if (errorCode == 'auth/email-already-in-use' || errorCode == 'auth/invalid-email' || errorCode == 'auth/operation-not-allowed') {
    //             $("#registerForm #email").addClass(function() {
    //                 $(this).after(errorElement);
    //                 return "is-invalid";
    //             });
    //         } else if (errorCode == 'auth/weak-password') {
    //             $('#registerForm #password').addClass(function() {
    //                 $(this).after(errorElement);
    //                 return "is-invalid";
    //             });
    //         } else {
    //             console.log(errorMessage);
    //         }
    //         console.log(error);
    //         console.log("Auth Error");
    //         restoreButton();
    //         return false;
    //     });
    // });
})
