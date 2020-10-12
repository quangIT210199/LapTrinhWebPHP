//fitler
// searchProduct.on("keyup", function() {
//     let value = $(this).val().toLowerCase();
//     $("#employeeList tr").filter(function() {
//         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//     });
// });

$(document).ready(function(){
    $("#searchEmployee").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#employeeList tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
});