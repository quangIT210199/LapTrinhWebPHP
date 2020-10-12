function login(event) {
    event.preventDefault();

    data = {
        email: $("#input-email").val(),
        password: $("#input-password").val(),
    };

    // còn cái hàm check email bên index.js ngoài cùng (chính)
    if (!validateEmail(data.email)) {
        return false;
    }

    if(data.password === ""){
        return false;
    }

    console.log(data);

    let request = $.ajax({//gọi api login
        type: "post",
        url: "http://localhost/backendbyq/api/login",
        data: data,
    });
    
    // let path = "C:\Users\quang\OneDrive\Desktop\CodeCNPM\frontend-master\Home\index.html";

    request.done(function (response, textStatus, jqXHR) {
        // Log a message to the console
        console.log("Login OK!");
        console.log(response);
        //lấy 2 mảng vs 2 key ra nhét vào localstorage
        localStorage.setItem("access_token",response.access_token);
        localStorage.setItem("profile",JSON.stringify(response.profile));
        window.location.href = "/home";
    });

    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR.responseJSON);
        // alertError("Email hoặc mật khẩu không chính xác.")
        alert("Email hoặc mật khẩu không chính xác.");
    });
}