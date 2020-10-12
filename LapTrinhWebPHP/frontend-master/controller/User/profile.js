
let token = localStorage.getItem("access_token");

if (!token) {//nếu localstore k có accesstoke thì k còn hạn truy cập
    window.location.href = "/login";
}

//Lưu profile vào LocalStorage để lấy profile để trao quyền(autho)
let request_profile = $.ajax({
    type: "get",
    headers: {
        'Authorization': `Bearer ${token}`,
    },
    url: "http://127.0.0.1/backendbyq/api/profile",
    crossDomain: true,
    
});
request_profile.done(function (response, textStatus, jqXHR) {
    // Log a message to the console
    console.log(response);
    localStorage.setItem("profile", JSON.stringify(response));
});

request_profile.fail(function (jqXHR, textStatus) {
    console.log(jqXHR.responseJSON);
    window.location.href = "/login";
});