let pro_name = $("#pro_name");
let pro_saleprice = $("#saleprice");
let pro_purchaseprice = $("#purchaseprice");
let pro_quantity = $("#quantity");
let pro_image = $("#pro_image");
let preview = document.querySelector("#proImg_preview");
let base64Img;
// let href = window.location.href;
// const idReg = /pro_id/;
// let pro_id = href.slice(idReg.exec(href).index + 7);

let pro_id = GetURLParameter('pro_id');
console.log(pro_id);

// let product_id = {
//     "pro_id": pro_id.toString()
// }

previewFile = () => {
    const file = document.querySelector('input[type=file]').files[0];
    const reader = new FileReader();

    reader.onload = function() {
        // convert image file to base64 string
        base64Img = reader.result;
        preview.src = reader.result;
    };
    reader.readAsDataURL(file);
};
//==========================================================
let getProData = $.get({
    url: "http://localhost/backendbyq/api/allproducts",
    data: {
        pro_id: pro_id
    }
});

getProData.done(data => {
    console.log(data.body);
    pro_name.val(data.body[0].pro_name);
    pro_saleprice.val(data.body[0].pro_saleprice);
    pro_purchaseprice.val(data.body[0].pro_purchaseprice);
    pro_quantity.val(data.body[0].pro_quantity);
    preview.src = data.body[0].pro_image;
});
getProData.fail(() => {
    alert("Lấy thông tin sản phẩm lỗi!");
});
//==========================================================
editProduct = () => {
    let data = {
        "pro_id": pro_id.trim(),
        "pro_name": pro_name.val().trim(),
        "pro_quantity": pro_quantity.val().trim(),
        "pro_saleprice": pro_saleprice.val().trim(),
        "pro_purchaseprice": pro_purchaseprice.val(),
        "pro_image": base64Img
    };
    let createPro = $.ajax({
        "url": "http://localhost/backendbyq/api/updateproduct",
        "method": "POST",
        "timeout": 0,
        "data": JSON.stringify(data)
    });
    createPro.done(data => {
        if (data.msg == "ok") {
            window.location.href = "product/index.html";
        }
    });

    createPro.fail(() => {
        alert("Cập nhật sản phẩm lỗi!");
    });
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