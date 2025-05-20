function enviarComanda() {
  const numeroComanda = document.getElementById("inputNumeroComanda").value.trim();

  if (!numeroComanda) {
    alert("Por favor, digite o número da comanda.");
    return;
  }

  const produtosSelecionados = [];
  let erroQuantidade = false;
  let algumProdutoMarcado = false;

  const produtos = document.querySelectorAll('.item-produto');

  produtos.forEach(produto => {
    produto.querySelector('.quantidade').classList.remove("erro");
  });

  produtos.forEach(produto => {
    const checkbox = produto.querySelector('.checkbox-produto');
    const quantidadeInput = produto.querySelector('.quantidade');

    if (checkbox.checked) {
      algumProdutoMarcado = true;

      const quantidade = parseFloat(quantidadeInput.value);
      if (!quantidade || quantidade <= 0) {
        erroQuantidade = true;
        quantidadeInput.classList.add("erro");
      } else {
        produtosSelecionados.push({
          nome: checkbox.dataset.produto,
          quantidade,
          unidade: checkbox.dataset.unidade || "",
          observacao: produto.querySelector('.observacao').value || ""
        });
      }
    }
  });

  if (!algumProdutoMarcado) {
    alert("Por favor, selecione pelo menos um produto.");
    return;
  }

  if (erroQuantidade) {
    alert("Por favor, insira uma quantidade válida para todos os produtos selecionados.");
    return;
  }

  // Aqui segue o código para enviar a comanda ou outras ações
}
