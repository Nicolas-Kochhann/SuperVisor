const contador = document.getElementById("contador-interesses");
const botao = document.getElementById("submit");
let quant = document.querySelectorAll("input[type='checkbox']:checked").length;
const checkboxes = document.querySelectorAll("input[type='checkbox']");

checkboxes.forEach((checkbox) => {
  checkbox.addEventListener("change", (event) => {
    if (event.target.checked) {
      quant++;
    } else {
      quant--;
    }

    contador.innerText = quant + " / 3";

    if (quant >= 3) {
      botao.disabled = false;
    } else {
      botao.disabled = true;
    }
  });
});

window.addEventListener("DOMContentLoaded", () => {
  contador.innerText = quant + " / 3";
  if (quant >= 3) {
    botao.disabled = false;
  } else {
    botao.disabled = true;
  }
});
