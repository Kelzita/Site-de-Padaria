document.addEventListener('DOMContentLoaded', function () {
  // Adiciona o evento de toggle para exibir/ocultar senha
  const toggleSenha = document.getElementById('toggleSenha');
  const senhaInput = document.getElementById('senha_funcionario');

  toggleSenha.addEventListener('click', function () {
    if (senhaInput.type === 'password') {
      senhaInput.type = 'text';
      toggleSenha.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
      senhaInput.type = 'password';
      toggleSenha.innerHTML = '<i class="fas fa-eye"></i>';
    }
  });

  document.getElementById('formCadastro').addEventListener('submit', function (e) {
    e.preventDefault();

    const funcionario = {
      nome: document.getElementById('nomefunc').value,
      cpf: document.getElementById('cpf').value,
      rg: document.getElementById('rg').value,
      senha: senhaInput.value,
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
