//Animation and calcu cash
let productResult = $("#productResult");
let searchProduct = $("#searchProduct");
let categories = $("#categories");

let createSelectedTag = (obj) => {
    return `<option value="${obj.proCate_code}">${obj.proCate_des}</option>`;
}

//Show result when focus
searchProduct.focus(() => {
    productResult.css("height", "200px");
});

searchProduct.focusout(() => {
    productResult.css("height", "0");
});

//set categories selected
let cates = $.ajax({
    type: 'GET',
    url: 'http://localhost/backend/api/allcates',
    contentType: 'application/json'
});

cates.done(data => {
    data.body.map(item => {
        categories.append(createSelectedTag(item));
    });
});

cates.fail(() => {
    console.log("Fail");
});