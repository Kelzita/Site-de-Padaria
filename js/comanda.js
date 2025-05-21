function Comanda() {
    const numero = document.getElementById("numeroComanda").value.trim();
    const linhas = document.querySelectorAll(".comanda tbody tr");
    let resultado = `Comanda Nº: ${numero} enviada!`;
  
    linhas.forEach((linha, index) => {
      const colunas = linha.querySelectorAll("td");
      const codProd = colunas[0].innerText.trim();
      const produto = colunas[1].innerText.trim();
      const qtde = colunas[2].innerText.trim();
  
      // Adiciona à string somente se houver algo preenchido
    
    });
  
    alert(resultado);
  }
  