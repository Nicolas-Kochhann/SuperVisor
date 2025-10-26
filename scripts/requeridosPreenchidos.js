const botaoSubmit = document.getElementById("submit");
const requiredInputs = document.querySelectorAll("input[required]");

function checkForm() {
  let allFilled = true;
  requiredInputs.forEach((input) => {
    if (!input.value.trim()) allFilled = false;
  });

  botaoSubmit.disabled = !allFilled;
}

requiredInputs.forEach((input) => {
  input.addEventListener("input", checkForm);
});
