let categoriesList = $("#categoriesList");
let searchCate = $("#searchCate");
let createCateTableTag = (obj) => {
    return (
        `<tr id="${obj.proCate_ID}">
            <th scope="row">${obj.proCate_ID}</th>
            <td>${obj.proCate_des}</td>
            <td>${obj.proCate_code}</td>
            <td><button class="btn btn-warning" onclick=delCate("${obj.proCate_ID}")>Xóa</button></td>
        </tr>`
    );
}
//<td><a href="updateCate.html?proCate_id=${obj.proCate_ID}" class="btn btn-info">Chỉnh sửa</a></td>
let fetchCateList = $.ajax({
    type: 'GET',
    url: 'http://localhost/backendbyq/api/allcates'
});

fetchCateList.done(data => {
    data.body.map(item => {
        categoriesList.append(createCateTableTag(item));
    });
});

//filter cate
searchCate.on("keyup", function() {
    let value = $(this).val().toLowerCase();
    $("#categoriesList tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});