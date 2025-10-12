let passwordField = document.getElementById("senha");
let showPasswordButton = document.getElementById("show-password");

showPasswordButton.addEventListener("click", function showPassword() {
  if (passwordField.type === "password") {
    passwordField.type = "text";
  } else {
    passwordField.type = "password";
  }
  showPasswordButton.classList.toggle("showing");
});
