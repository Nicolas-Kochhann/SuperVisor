const contador = document.getElementById("contador-interesses");
const botao = document.getElementById("submit");
let quant = 0;
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

/* 
window.addEventListener("DOMContentLoaded", () => {
  checkboxes.forEach((cb) => (cb.checked = false));
  contador.innerText = quant + " / 3";
  botao.disabled = true;
});
*/
