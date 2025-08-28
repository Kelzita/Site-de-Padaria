function carregarEstoque() {
    const corpoTabela = document.getElementById('corpoTabela');
    corpoTabela.innerHTML = '';
  
    const produtos = JSON.parse(localStorage.getItem('produtos')) || [];
  
    produtos.forEach(produto => {
      const linha = document.createElement('tr');
      linha.innerHTML = `
        <td>${produto.id}</td>
        <td>${produto.nome}</td>
        <td>${produto.validade}</td>
        <td>${produto.quantidade}${produto.quantidade < 20 ? '⚠️' : ''}</td>
        <td>${produto.fornecedor}</td>
        <td>${produto.unidade}</td>
        <td>R$ ${parseFloat(produto.preco).toFixed(2)}</td>
      `;
      corpoTabela.appendChild(linha);
      if (produto.quantidade < 20) {
        alerta.innerHTML += `<p>⚠️ Produto <strong>${produto.nome.toUpperCase()}</strong> está com quantidade baixa!</p>`;
      }
    });
  }

  
  function filtrar() {
    const filtro = document.getElementById("busca").value.toUpperCase();
    const linhas = corpoTabela.getElementsByTagName("tr");
  
    for (let i = 0; i < linhas.length; i++) {
      const colunas = linhas[i].getElementsByTagName("td");
      const id = colunas[0]?.textContent.toUpperCase() || "";
      const nome = colunas[1]?.textContent.toUpperCase() || "";
  
      // Verifica se o filtro aparece no ID ou no Nome
      if (id.includes(filtro) || nome.includes(filtro)) {
        linhas[i].style.display = "";
      } else {
        linhas[i].style.display = "none";
      }
    }
  }
  
  window.onload = carregarEstoque;