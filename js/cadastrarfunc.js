document.addEventListener('DOMContentLoaded', function () {
  document.querySelector('.formulario-cadastro').addEventListener('submit', function (e) {
    e.preventDefault();

    // Coleta os dados do formulário
    const funcionario = {
      nome: document.getElementById('nomefunc').value,
      cpf: document.getElementById('cpf').value,
      rg: document.getElementById('rg').value,
      senha: document.getElementById('senha').value,
      email: document.getElementById('email').value,
      telefone: document.getElementById('telefone').value,
      rua: document.getElementById('rua').value,
      numero: document.getElementById('numero').value,
      bairro: document.getElementById('bairro').value,
      cidade: document.getElementById('cidade').value,
      uf: document.getElementById('uf').value,
      funcao: document.getElementById('funcao').value,
      admissao: document.getElementById('admissao').value,
      salario: document.getElementById('salario').value
    };

    // Recupera os funcionários já cadastrados no localStorage
    const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];

    // Adiciona o novo funcionário ao array
    funcionarios.push(funcionario);

    // Salva o array de funcionários no localStorage
    localStorage.setItem('funcionarios', JSON.stringify(funcionarios));

    // Redireciona para a página de gestão de funcionários
    window.location.href = 'ListadeFuncionario.html';
  });
});


