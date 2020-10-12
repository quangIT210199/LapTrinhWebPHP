let catetegories = []; // dữ liệu danh mục sẽ lưu vào đây
let cates_quantity = [];
let products_name = [];
let products_quantity = [];
let products_price = [];
let user_quantity = [0, 0, 0];

let getProList = $.ajax({
    type: "GET",
    url: "http://localhost/backendbyq/api/allproducts"
});

getProList.done(data => {
    let index = 0;
    // console.log(data.body);
    // for (let i = 0; i < data.body.length; i++) {
    //     if (i == 0) {
    //         catetegories.push(data.body[0].pro_cate);
    //         cates_quantity.push(Number(data.body[0].pro_quantity));
    //     } else {
    //         if (data.body[i - 1].pro_cate != data.body[i].pro_cate) {
    //             catetegories.push(data.body[i].pro_cate);
    //             cates_quantity.push(Number(data.body[i].pro_quantity));
    //             index++;
    //         } else {
    //             cates_quantity[index] += Number(data.body[i].pro_quantity);
    //         }
    //     }
    // }
    data.body.map(item => {
        products_name.push(item.pro_id);
        products_quantity.push(item.pro_quantity);
        products_price.push(Number(item.pro_purchaseprice) - Number(item.pro_saleprice));
    });
});

getProList.fail(() => {
    console.log('error');
});

setTimeout(() => {
    var bar = document.getElementById('bar_chart').getContext('2d');
    var bar_chart = new Chart(bar, {
        type: 'bar',
        data: {
            labels: products_name,
            datasets: [{
                label: "Số lượng sản phẩm",
                data: products_quantity,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                xAxes: [{
                    gridLines: {
                        offsetGridLines: true
                    }
                }]
            }
        }
    });

}, 1000);


let dropdown = document.getElementsByClassName("dropdown-btn");

for (let i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function() {
        let dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}