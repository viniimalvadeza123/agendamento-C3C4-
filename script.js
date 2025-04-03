document.querySelector("form").addEventListener("submit", function(event) {
    let senha = document.getElementById("senha").value;
    let confirmarSenha = document.getElementById("confirmarSenha").value;

    if (senha.length < 8) {
        alert("A senha deve ter pelo menos 8 caracteres!");
        event.preventDefault();
    }

    if (!/[A-Z]/.test(senha) || !/[0-9]/.test(senha)) {
        alert("A senha deve conter pelo menos uma letra maiúscula e um número!");
        event.preventDefault();
    }

    if (senha !== confirmarSenha) {
        alert("As senhas não coincidem!");
        event.preventDefault();
    }
});
