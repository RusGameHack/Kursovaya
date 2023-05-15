document.getElementById("login-toggle").addEventListener("click", function() {
    document.getElementById("login-form").classList.add("visible");
    document.getElementById("register-form").classList.remove("visible");
});
  
document.getElementById("register-toggle").addEventListener("click", function() {
    document.getElementById("register-form").classList.add("visible");
    document.getElementById("login-form").classList.remove("visible");
});