function maskCpf(value) {
    value = value.replace(/\D/g, '').slice(0, 11);
    if (value.length > 9) {
        return value.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4');
    }
    if (value.length > 6) {
        return value.replace(/(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3');
    }
    if (value.length > 3) {
        return value.replace(/(\d{3})(\d{0,3})/, '$1.$2');
    }
    return value;
}

function maskPhone(value) {
    value = value.replace(/\D/g, '').slice(0, 11);
    if (value.length > 10) {
        return value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
    }
    if (value.length > 6) {
        return value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    }
    if (value.length > 2) {
        return value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
    }
    return value;
}

document.addEventListener('DOMContentLoaded', () => {
    const cpf = document.getElementById('cpf');
    const phone = document.getElementById('phone');

    if (cpf) {
        cpf.addEventListener('input', (e) => {
            e.target.value = maskCpf(e.target.value);
        });
    }

    if (phone) {
        phone.addEventListener('input', (e) => {
            e.target.value = maskPhone(e.target.value);
        });
    }
});
