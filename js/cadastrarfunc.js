document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('formCadastro').addEventListener('submit', function (e) {
    e.preventDefault();

    const funcionario = {
      nome: document.getElementById('nomefunc').value,
      cpf: document.getElementById('cpf').value,
      rg: document.getElementById('rg').value,
      senha: document.getElementById('senha_funcionario').value,
      email: document.getElementById('email').value,
      telefone: document.getElementById('telefone').value,
      rua: document.getElementById('rua').value,
      numero: document.getElementById('numero').value,
      bairro: document.getElementById('bairro').value,
      cidade: document.getElementById('cidade').value,
      uf: document.getElementById('uf').value,
      funcao: document.getElementById('funcao').value,
      admissao: document.getElementById('admissao').value,
      salario: document.getElementById('salario').value,
      ativo: true // adiciona essa flag para funcionar na listagem
    };

    const funcionarios = JSON.parse(localStorage.getItem('funcionarios')) || [];
    funcionarios.push(funcionario);
    localStorage.setItem('funcionarios', JSON.stringify(funcionarios));

    window.location.href = 'ListadeFuncionario.html';
  });
});
