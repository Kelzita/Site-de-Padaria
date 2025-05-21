const modal = document.getElementById('modal');
const closeModal = document.getElementById('closeModal');

document.querySelector('.abrircaixa').addEventListener('click', () => {
    modal.style.display = 'block';
});

closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

const nomeUsuario = localStorage.getItem('nomeUsuario');
if (nomeUsuario) {
    document.getElementById('saudacao').textContent = 'BEM-VINDO(A) ' + nomeUsuario;
} else {
    document.getElementById('saudacao').textContent = 'BEM-VINDO(A)';
}

// Redireciona para a página do caixa após registrar o valor inicial
document.getElementById('valorInicialForm').addEventListener('submit', (event) => {
    event.preventDefault(); // Impede o envio do formulário padrão
    const valorInicial = document.getElementById('salario').value;
    if (valorInicial) {
        localStorage.setItem('valorInicialCaixa', valorInicial); // Armazena o valor no localStorage
        alert(`Valor inicial de R$${valorInicial} registrado com sucesso!`);
        modal.style.display = 'none'; // Fecha o modal
        window.location.href = 'caixa.html'; // Redireciona para a página do caixa
    } else {
        alert('Por favor, insira um valor inicial válido.');
    }
});
