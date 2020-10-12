//hàm delete Cate
delCate = (cate_id) =>{
    //tạo 1 biến lưu id của sp click
    let cateID = {proCate_ID: cate_id};
    //gọi request
    let delCate = $.ajax({
        type: 'POST',
        url: "http://localhost/backendbyq/api/delCate",
        data: cateID
    });

    //hàm done khi request dc trả tc
    delCate.done(data => {
        if(data.msg == "Cate deleted successfully"){
            let CatelId = "#" + cate_id;
            //gọi hàm css thêm thuộc css
            $(CatelId).css('display', 'none');
        }
        else{
            alert("Xóa sản phẩm lỗi!");
        }
    });

    //hàm fail
    delCate.fail((XHR, statuscode) => {
        console.log(statuscode);
    })
};