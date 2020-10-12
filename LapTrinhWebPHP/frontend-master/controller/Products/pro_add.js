let pro_name = $("#pro_name");
let pro_saleprice = $("#saleprice");
let pro_purchaseprice = $("#purchaseprice");
let pro_cates = $("#product_cates");
let pro_quantity = $("#quantity");
let pro_image = $("#pro_image");
let preview = document.querySelector("#proImg_preview");
let base64Img;

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
//===========================================================
let createCateTag = (obj) => {
    return (
        `<option value="${obj.proCate_code}">${obj.proCate_des}</option>`
    );
}
//`<option value="${obj.cate_code}">${obj.cate_name}</option>`
let getCate = $.get({
    url: "http://localhost/backendbyq/api/allcates"
});
getCate.done(data => {
    data.body.map(item => {
        pro_cates.append(createCateTag(item));
    });
});

getCate.fail(() => {
    alert("Lỗi cập nhật danh mục!")
});
//===========================================================
addProduct = () => {
    if (pro_cates.val() != "none") {
        let data = {
            pro_name: pro_name.val().trim(),
            pro_quantity: pro_quantity.val().trim(),
            pro_categories: pro_cates.val().trim(),
            pro_saleprice: pro_saleprice.val().trim(),
            pro_purchaseprice: pro_purchaseprice.val(),
            pro_image: base64Img
        };

        
        let createPro = $.ajax({
            type: "POST",
            url: "http://localhost/backendbyq/api/createproduct",
            // contentType: 'application/json',
            data: JSON.stringify(data)
        });
// window.location.href = "/product/index.html"
        createPro.done(data => {
            
            (data.msg == 'ok') ? window.location.href = "/product/index.html" : alert("Tạo sản phẩm lỗi quang!");
           
        });

        createPro.fail(() => {
            console.log("Fail");
        });
    } else {
        alert("Điền đầy đủ các trường!");
    }
    return false;
}