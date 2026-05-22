let cpf = document.getElementById("cpf");

cpf.addEventListener("input", function () {
    let valor = cpf.value;
    valor = valor.replace(/\D/g, "");

    if (valor.length > 3) {
        valor = valor.slice(0, 3) + "." + valor.slice(3);
    }
    if (valor.length > 7) {
        valor = valor.slice(0, 7) + "." + valor.slice(7);
    }
    if (valor.length > 11) {
        valor = valor.slice(0, 11) + "-" + valor.slice(11);
    }
    valor = valor.slice(0, 14);
    cpf.value = valor;
});