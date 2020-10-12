//Animation and calcu cash
// let dropdown = document.getElementsByClassName("dropdown-btn");
let employeeResult = $("#employeeResult");
let searchEmployee = $("#searchEmployee");

//Show result when focus
searchEmployee.focus(() => {
    employeeResult.css("height", "200px");
});

searchEmployee.focusout(() => {
    employeeResult.css("height", "0");
});