let cateDes = $("#cateDes");
let cateCode = $("#cateCode");

let catepro_id = GetURLParameter("proCate_id");

let getCate = $.ajax({
    type: 'GET',
    url: "http://localhost/backendbyq/api/allcates",
    data: {
        cate_id: catepro_id
    }
});

getCate.done( function(response, textStatus, jqXHR){
    let body = response.body[0];

    cateDes.val(body['proCate_des']);
    cateDes.val(body['proCate_code']);
    
});

getCate.fail(() => {
    console.log("Fail to get data");
    alert("Fail to get data");
});

//Update
updateCate = () => {
    if(cateDes.val().trim() == "" || cateCode.val().trim() == ""){
        alert("Nhập thiếu, hãy nhập đủ !!!");
    }
    else{
        let update = {
            cate_id: catepro_id,
            cate_name: cateDes.val(),
            cate_code: cateCode.val()
        }
        console.log(update);
        
        let upCate = $.ajax({
            type: 'POST',
            url: "http://localhost/backendbyq/api/editEmployee",
        })
    }
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