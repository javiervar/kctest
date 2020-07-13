$(document).ready(function () {
    if (localStorage.getItem("kc_data") !== null) {
        
        var data=JSON.parse(localStorage.getItem("kc_data"));
        console.log(data)
        $("#user_name").val(data.user_name);
        $("#password").val(data.password);
        $("#remember").prop( "checked", true );;
    }
});

function login(event) {
    event.preventDefault();

    var params = $("#login-form").serialize();

    $.ajax({
        type: "POST",
        url: "../api/src/auth.php",
        data: params,
        cache: false,
        success: function (data) {
            var data = JSON.parse(data);

            if (data.error) {
                alert(data.txt);
            } else {
                if ($("#remember")[0].checked) {
                    var data = {
                        user_name: $("#user_name").val(),
                        password: $("#password").val()
                    }
                    console.log(data);
                    localStorage.setItem('kc_data', JSON.stringify(data));

                } else {
                    localStorage.removeItem('kc_data');
                }

                window.location.href = "users.html";

            }
        }
    });
}