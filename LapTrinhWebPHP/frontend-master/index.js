function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

let profile = JSON.parse(localStorage.getItem('profile'));

$('.profile_title').text(`Chào mừng bạn ${profile.name}`);//String ES6

let role = profile.role;
console.log(role);

if(role == 'ADMIN'){
    $('.user_role').text('Admin');
} 
if(role == "NV"){
    $('.user_role').text('Nhân viên');
}

// let dropdown = document.getElementsByClassName("dropdown-btn");
// for (let i = 0; i < dropdown.length; i++) {
//     dropdown[i].addEventListener("click", function() {
//         let dropdownContent = this.nextElementSibling;
//         if (dropdownContent.style.display === "block") {
//             dropdownContent.style.display = "none";
//         } else {
//             dropdownContent.style.display = "block";
//         }
//     });
// }