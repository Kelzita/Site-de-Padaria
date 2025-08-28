document.addEventListener('DOMContentLoaded', function () {
  document.querySelector('.formulario-cadastro').addEventListener('submit', function (e) {
    e.preventDefault(); // Previne o envio tradicional do formulário

    // Recupera os produtos já cadastrados no localStorage
    const produtos = JSON.parse(localStorage.getItem('produtos')) || [];

    // Gera um novo ID automaticamente (incremental)
    const novoId = produtos.length > 0 ? Math.max(...produtos.map(p => parseInt(p.id))) + 1 : 1;

    // Coleta os dados do formulário (sem o campo de ID)
    const produto = {
      id: novoId,
      nome: document.getElementById('nome').value,
      validade: document.getElementById('validade').value,
      quantidade: document.getElementById('quantidade').value,
      fornecedor: document.getElementById('fornecedor').value,
      unidade: document.getElementById('unidade').value,
      preco: document.getElementById('preco').value
    };

    // Adiciona o novo produto ao array
    produtos.push(produto);

    // Salva de volta no localStorage
    localStorage.setItem('produtos', JSON.stringify(produtos));

    // Redireciona para a página de gestão de estoque
    window.location.href = 'gestaoestoque.html';
  });
});
