let productsList = $("#employeeList ");
let createproTag = (obj) => {
    return (
        `<tr id="${obj.pro_id}">
            <th scope="row">${obj.pro_id}</th>
            <td><img src="${obj.pro_image}" height="40px" style="margin-right: 10px"><a href="updateProducts.html?pro_id=${obj.pro_id}">${obj.pro_name}</a></td>
            <td>${obj.pro_cate}</td>
            <td>${obj.pro_quantity}</td>
            <td>${obj.pro_saleprice}</td>
            <td>${obj.pro_purchaseprice}</td>
            <td><button class="btn btn-warning" onclick=delPro("${obj.pro_id}")>Xóa</button></td>
            <td><a href="updateProducts.html?pro_id=${obj.pro_id}" class="btn btn-info">Chỉnh sửa</a></td>
        </tr>`
    );
}

let getProList = $.ajax({
    type: "GET",
    url: "http://localhost/backendbyq/api/allproducts"
});

getProList.done(data => {
    data.body.map(item => {
        productsList.append(createproTag(item));
    });
})

getProList.fail(() => {
    console.log("fail");
})

getProList.fail(() => {
    console.log("Failed");
});

// DELETE
delPro = (product_id) => {
    let proIDD = { pro_id: product_id };
    let delProduct = $.ajax({
        "url": "http://localhost/backendbyq/api/deleteproduct",
        "method": "POST",
        "timeout": 0,
        "headers": {
            "Content-Type": "text/plain"
        },
        "data": JSON.stringify(proIDD)
    });
    delProduct.done(data => {
        if (data.msg == "ok") {
            let prodelID = "#" + product_id;
            $(prodelID).css('display', 'none');
        } else {
            alert("Xóa sản phẩm lỗi!");
        }
    });
    delProduct.fail((XHR, statuscode) => {
        console.log(statuscode);
    })
};

//====================================================
$("#searchProduct").on("keyup", function() {
    let value = $(this).val().toLowerCase();
    $("#productsList tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});