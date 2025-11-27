const botaoSubmit = document.getElementById("submit");
const senhaInput = document.getElementById("senha");
const len = document.getElementById("tamanho");
const letter = document.getElementById("letra");
const number = document.getElementById("numero");

const requiredInputs = document.querySelectorAll("input[required]");

function checkPassword() {
  const valor = senhaInput.value;

  const hasNumber = /\d/.test(valor);
  number.classList.toggle("valido", hasNumber);
  number.classList.toggle("invalido", !hasNumber);

  const hasLetter = /[a-zA-Z]/.test(valor);
  letter.classList.toggle("valido", hasLetter);
  letter.classList.toggle("invalido", !hasLetter);

  const hasLength = valor.length >= 8;
  len.classList.toggle("valido", hasLength);
  len.classList.toggle("invalido", !hasLength);

  return hasNumber && hasLetter && hasLength;
}

senhaInput.addEventListener("change", checkPassword);

function checkForm() {
  // Check if all required inputs are filled
  let allFilled = true;
  requiredInputs.forEach((input) => {
    if (!input.value.trim()) allFilled = false;
  });

  // Enable submit only if password is valid AND all required fields are filled
  botaoSubmit.disabled = !(allFilled && checkPassword());
}

// Attach event listener to all required inputs including password
requiredInputs.forEach((input) => {
  input.addEventListener("input", checkForm);
});
