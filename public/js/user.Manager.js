/******************************************************************************************************
 File						: 	user.Manager.js
 Description					:	User related functionality.
 Project 					:	onyourcircle
 Date						:       07.08.2014
 Language 					: 	PHP 5
 Database 					: 	Mysql
 Author						:       Namjith Aravind
 Development Center				:	Wiztelsys
 Modified On (By)                               :        07.08.2014
 ****************************************************************************************************/


/**
 * Authenticate system login
 * @param {string} email User email id
 * @param {string} password User password
 * @returns {bool} true or false or error
 */
function fncCheckUserLogin() {
    var fields = $('#loginForm').serializeArray();
    var params = {};
    var url = BASE_URL + '/admin/process';
    $.each(fields, function(i, field) {

        params[field.name] = field.value;

    });

    $.ajax({
        type: 'POST',
        url: url,
        dataType: 'html',
        data: params,
        success: function(data) {
            var data = $.parseJSON(data);
            if (data.status == true)
            {
                window.location.replace(BASE_URL + "/admin/dashboard");
            }
            else
            {
                $("#box").shake();
                $("#system_email_error").hide();
                $("#system_password_error").hide();
                if (data.email == false) {

                    $("#system_password_div").removeClass("has-error");
                    $("#system_email_div").addClass("has-error");
                    $("#system_email_error").show();

                }
                if (data.password == false) {
                    $("#system_email_div").removeClass("has-error");
                    $("#system_password_div").addClass("has-error");
                    $("#system_password_error").show();

                }
                return false;
            }
        }
    });
}

