function cadastrar(event) {
  event.preventDefault(); 

  const nome = document.getElementById('nomefunc').value.trim();
  const cnpj = document.getElementById('cnpj').value.trim();
  const email = document.getElementById('rg').value.trim();
  const telefone = document.getElementById('telefone').value.trim();

  if (!nome || !cnpj || !email || !telefone) {
    alert('Por favor, preencha todos os campos!');
    return;
  }

  const fornecedores = JSON.parse(localStorage.getItem('fornecedores')) || [];

  // Gerar ID automático (incremental)
  let novoId = 1;
  if (fornecedores.length > 0) {
    const ids = fornecedores.map(f => parseInt(f.id));
    novoId = Math.max(...ids) + 1;
  }

  // Cria o novo fornecedor com ID automático e 'ativo: true'
  const novoFornecedor = { 
    id: novoId.toString(), 
    nome, 
    cnpj, 
    email, 
    telefone, 
    ativo: true 
  };

  fornecedores.push(novoFornecedor);
  localStorage.setItem('fornecedores', JSON.stringify(fornecedores));

  alert('Fornecedor cadastrado com sucesso!');
  console.log('Redirecting to listadeFornecedores.html');
  window.location.href = './listadeFornecedores.html'; // Ensure the path is correct
}
