function logout() {
    console.log("logout");    
    localStorage.clear();
    window.location.href = "/login"
}
//clear hết access toke lưu trên localStorage(ở FE) để ngắt quyền truy cập khi đã logout