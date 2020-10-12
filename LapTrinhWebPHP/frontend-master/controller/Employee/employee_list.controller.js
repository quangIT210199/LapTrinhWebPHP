$(function () {
    let employeeList = $("#employeeList");//tạo biến lấy thẻ có id 

    let token = localStorage.getItem('access_token');

    //Fetch data api
    let employeesList = $.ajax({ // sử dụng get để gọi request
        type: "get",
        headers: {
            Authorization: `Bearer ${token}`,
        },
        url: "http://localhost/backendbyq/api/user",
    })

    let createTag = (item) => { // tạo hàm để trả về chuỗi
        return (
            `<tr id="${item.id}">
                <th scope="row">${item.id}</th>
                <td><a href="editemployee.html?id=${item.id}">${item.name}</a></td>
                <td>${item.email}</td>
                <td>${item.sex}</td>
                <td>${item.phone}</td>
                <td>${item.date}</td>
                <td>${item.role}</td>
                <td>${item.address}</td>
                <td><button class="btn btn-warning" onclick=delEmployee("${item.id}")>Xóa</button></td>
                <td><a href="editemployee.html?id=${item.id}" class="btn btn-info">Chỉnh sửa</a></td>
            </tr>`
        );
    }

    employeesList.done(data => {// data chỏ vào mảng userArr["body"] rồi lấy ra từng phần tử
        data.body.map(item => {
            employeeList.append(createTag(item));//chèn chuỗi ở createTag
        });
    });

    employeesList.fail((jqXHR, textStatus, errorThrown) => {
        alert("Không có quyền");
    });
});
