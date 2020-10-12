//hàm delete Employee
delEmployee = (employee_id) =>{
    //tạo 1 biến lưu id của sp click
    let employeeID = {id: employee_id};
    //gọi request
    let delEmployee = $.ajax({
        headers: {
            Authorization: `Bearer ${token}`,
        },
        type: 'POST',
        url: "http://localhost/backendbyq/api/delEmployee",
        dataType: "json",
        data: JSON.stringify(employeeID)
    });

    //hàm done khi request dc trả tc
    delEmployee.done(data => {
        if(data.msg == "Employee deleted successfully"){
            let employeeDelId = "#" + employee_id;
            //gọi hàm css thêm thuộc css
            $(employeeDelId).css('display', 'none');
        }
        else{
            alert("Xóa sản phẩm lỗi!");
        }
    });

    //hàm fail
    delEmployee.fail((XHR, statuscode) => {
        console.log(statuscode);
    })
};