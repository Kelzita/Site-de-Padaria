document.addEventListener('DOMContentLoaded', function() {
    // Quando o formulário for submetido
    document.querySelector('.formulario-cadastro').addEventListener('submit', function(e) {
      e.preventDefault(); // Previne o envio tradicional do formulário
  
      // Coleta os dados do formulário
      const produto = {
        id: document.getElementById('id_produto').value,
        nome: document.getElementById('nome').value,
        validade: document.getElementById('validade').value,
        quantidade: document.getElementById('quantidade').value,
        fornecedor: document.getElementById('fornecedor').value,
        unidade: document.getElementById('unidade').value,
        preco: document.getElementById('preco').value
      };
  
      // Recupera os produtos já cadastrados no localStorage
      const produtos = JSON.parse(localStorage.getItem('produtos')) || [];
  
      // Adiciona o novo produto ao array
      produtos.push(produto);
  
      localStorage.setItem('produtos', JSON.stringify(produtos));
  
      // Redireciona para a página de gestão de estoque
      window.location.href = 'gestaoestoque.html';
    });
  });
  