//tạo biến cho các thẻ id
let nameEm = $("#name");
let emailEm = $("#email");
let passwordEm = $("#password");
let phoneEm = $("#phone");
let addressEm = $("#address");
let roleEm = $("#role");
let sexEm = $("#sex");
let dateEm = $("#date");

let em_id = GetURLParameter('id');

//Get detail product info
let getEmploye = $.get({
    headers: {
        Authorization: `Bearer ${token}`,
    },
    url: "http://localhost/backendbyq/api/user",
    data: {
        id: em_id
    }
});
//get value to tag html (biến getEmploye lưu toàn bộ giá trị của csdl trả về )
getEmploye.done(function (response, textStatus, jqXHR){
    let body = response.body[0];

    nameEm.val(body['name']);
    emailEm.val(body['email']);
    phoneEm.val(body['phone']);
    addressEm.val(body['address']);
    roleEm.val(body['role']);
    dateEm.val(body['date']);
    sexEm.val(body['sex']);

    let date_array = body['date'].split('-');
});

getEmploye.fail(() => {
    console.log("Fail to get data");
});

//Update
editEmployee = () => {
    if( nameEm.val().trim() == "" || emailEm.val().trim() == "" || passwordEm.val().trim() == "" ||
        phoneEm.val().trim() == "" || dateEm.val().trim() == "" || addressEm.val().trim() == "" ||
        roleEm.val().trim() == "Chọn chức vụ" || sexEm.val().trim() == "Chọn giới tính"){
            alert("Nhập thiếu, hãy nhập đủ !!!");
    } else {
        let editEmployee = {
            id2: em_id, //id này để select thôi, bên API phải có biến id2 như FE
            name: nameEm.val(),
            phone: phoneEm.val(),
            email: emailEm.val(),
            password: passwordEm.val(),
            sex: sexEm.val(),
            date: dateEm.val(),
            role: roleEm.val(),
            address: addressEm.val()
        };
        console.log(editEmployee);

        let editEm = $.ajax({
            headers: {
                Authorization: `Bearer ${token}`,
            },
            type: 'POST',
            url: "http://localhost/backendbyq/api/editEmployee",
            dataType: "json",
            data: JSON.stringify(editEmployee)
            // "url": "http://localhost/backendbyq/api/editEmployee",
            // "method": "POST",
            // "timeout": 0,
            // "headers": {
            // "Content-Type": "application/x-www-form-urlencoded"
            // },
            // "data": JSON.stringify(editEmployee) 
        });

        editEm.done(data => {
            (data.msg == "Edit employee successful") ? window.location.href = "employee.html": alert("Cập nhật nhân viên lỗi!");
        });

        editEm.fail((jqXHR, textStatus, errorThrown) => {
            alert("Failed");
        });
    }
    return false;
}
//Hàm tìm param
function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split("&");
    for (var i = 0; i < sURLVariables.length; i++) {
      var sParameterName = sURLVariables[i].split("=");
      if (sParameterName[0] == sParam) {
        return sParameterName[1];
      }
    }
}
