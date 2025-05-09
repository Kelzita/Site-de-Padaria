function Comanda() {
    const numero = document.getElementById("numeroComanda").value.trim();
    const linhas = document.querySelectorAll(".comanda tbody tr");
    let resultado = `COMANDA Nº: ${numero}\n\n`;
  
    linhas.forEach((linha, index) => {
      const colunas = linha.querySelectorAll("td");
      const codProd = colunas[0].innerText.trim();
      const produto = colunas[1].innerText.trim();
      const qtde = colunas[2].innerText.trim();
  
      // Adiciona à string somente se houver algo preenchido
      if (codProd || produto || qtde) {
        resultado += `Item ${index + 1} → COD: ${codProd} | PRODUTO: ${produto} | QTDE: ${qtde}\n`;
      }
    });
  
    alert(resultado);
  }
  