function cadastrar(event) {
    event.preventDefault(); 
  
    const id = document.getElementById('idfunc').value.trim();
    const nome = document.getElementById('nomefunc').value.trim();
    const cnpj = document.getElementById('cpf').value.trim();
    const email = document.getElementById('rg').value.trim();
    const telefone = document.getElementById('telefone').value.trim();
  
    if (!id || !nome || !cnpj || !email || !telefone) {
      alert('Por favor, preencha todos os campos!');
      return;
    }
  
    const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];
  
    // Verifica se já existe um fornecedor com o mesmo ID
    if (fornecedores.some(f => f.id === id)) {
      alert('Já existe um fornecedor com esse ID.');
      return;
    }
  
    const novoFornecedor = { id, nome, cnpj, email, telefone };
    fornecedores.push(novoFornecedor);
    localStorage.setItem('fornecedores', JSON.stringify(fornecedores));
  
    alert('Fornecedor cadastrado com sucesso!');
    window.location.href = 'gestaodeFornecedor.html'; 
  }
  