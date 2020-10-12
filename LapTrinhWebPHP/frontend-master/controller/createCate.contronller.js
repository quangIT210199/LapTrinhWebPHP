let createCate = $("#createCate");
let cateDes = $("#cateDes");
let cateCode = $("#cateCode");

createCate = () => {
    if (cateDes.val().trim() == "" || cateCode.val().trim() == "") {
        alert("Điền đầy đủ các trường thông tin");
    } else {
        let data = {
            cateCode: cateCode.val().trim().toLowerCase(),
            cateDes: cateDes.val().trim().toLowerCase()
        };
        let createCategories = $.ajax({
            type: 'POST',
            url: 'http://localhost/backendbyq/api/createcate',
            data: JSON.stringify(data)
        });
        createCategories.done(data => {
            (data.msg == "Create categories successful") ? window.location.href = "categories.html": alert("Tạo danh mục lỗi");
        });
        createCategories.fail(() => {
            alert("tạo danh mục mới bị lỗi!")
        })
    }
}