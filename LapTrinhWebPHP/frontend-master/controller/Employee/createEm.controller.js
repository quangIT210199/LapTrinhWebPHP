//tạo biến cho các thẻ id
let nameEm = $("#name");
let emailEm = $("#email");
let passwordEm = $("#password");
let phoneEm = $("#phone");
let dateEm = $("#date");
let addressEm = $("#address");
let roleEm = $("#role");
let sexEm = $("#sex");

//hàm tạo nhân viên
createEmployee = () =>{
    //check input fiedls
    if( nameEm.val().trim() == "" || emailEm.val().trim() == "" || passwordEm.val().trim() == "" ||
        phoneEm.val().trim() == "" || dateEm.val().trim() == "" || addressEm.val().trim() == "" ||
        roleEm.val().trim() == "Chọn chức vụ" || sexEm.val().trim() == "Chọn giới tính"){
            alert("Nhập thiếu, hãy nhập đủ !!!");
    }
    else {
        let newEmployee = {
            name: nameEm.val(),
            phone: phoneEm.val(),
            email: emailEm.val(),
            password: passwordEm.val(),
            sex: sexEm.val(),
            date: dateEm.val(),
            role: roleEm.val(),
            address: addressEm.val()
        };
        console.log(newEmployee);
        
        let createEm = $.ajax({
            headers: {
                Authorization: `Bearer ${token}`,
            },
            type: 'POST',
            url: "http://localhost/backendbyq/api/addEmployee",
            dataType: "json",
            data: JSON.stringify(newEmployee)
        });


        createEm.done(data => {
            (data.msg == "Create user successful") ? window.location.href = "employee.html" : alert("Thêm nhân viên lỗi quang!");;
        });
        createEm.fail(() => {
            alert("Thêm nhân viên lỗi này!")
        });
    }
    return false;
};