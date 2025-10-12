const senhaInput = document.getElementById("senha");
const len = document.getElementById("tamanho");
const letter = document.getElementById("letra");
const number = document.getElementById("numero");

senhaInput.addEventListener("input", function (event) {
    let regex = /\d/;
    if (regex.test(senhaInput.value)) {
        number.classList.toggle("valido", true);
        number.classList.toggle("invalido", false);
    } else {
        number.classList.toggle("valido", false);
        number.classList.toggle("invalido", true);
    };

    regex = /[a-zA-Z]/;
    if (regex.test(senhaInput.value)) {
        letter.classList.toggle("valido", true);
        letter.classList.toggle("invalido", false);
    } else {
        letter.classList.toggle("valido", false);
        letter.classList.toggle("invalido", true);
    };

    if (senhaInput.value.length >= 8) {
        len.classList.toggle("valido", true);
        len.classList.toggle("invalido", false);
    } else {
        len.classList.toggle("valido", false);
        len.classList.toggle("invalido", true);
    };
});
