document.addEventListener("DOMContentLoaded", function () {
    const itens = [
      { nome: "Pão Francês", preco: 1.00 },
      { nome: "Café", preco: 2.50 },
      { nome: "Bolo de Cenoura", preco: 4.00 }
    ];
  
    const lista = document.getElementById("itens-comanda");
    let total = 0;
  
    itens.forEach(item => {
      const li = document.createElement("li");
      li.textContent = `${item.nome} - R$ ${item.preco.toFixed(2)}`;
      lista.appendChild(li);
      total += item.preco;
    });
  
    document.getElementById("total").textContent = `R$ ${total.toFixed(2)}`;
  });
  
  function irParaCaixa() {
    window.location.href = "caixa.html";
  }
  