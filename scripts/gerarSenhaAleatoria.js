function gerarSenhaAleatoria(){
    const alfabeto = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    let senha = "SV0";

    for(let i = 0; i < 5; i++){
        senha += alfabeto.charAt(Math.floor(Math.random() * alfabeto.length));
    }

    const senhaInput = document.getElementById('senha');
    senhaInput.value = senha;
}

