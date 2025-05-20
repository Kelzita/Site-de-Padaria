const produtos = {
    '7891000055128': { nome: 'Pão Francês', preco: 0.80, categoria: 'Pães' },
    '7891000055555': { nome: 'Café com Leite', preco: 3.50, categoria: 'Bebidas' },
    '7891000055999': { nome: 'Pão de Queijo', preco: 1.50, categoria: 'Pães' },
    '7891000055888': { nome: 'Bolo de Fubá', preco: 4.00, categoria: 'Bolos' },
    '7891000055777': { nome: 'Sonho Recheado', preco: 3.00, categoria: 'Doces' },
    '7891000055666': { nome: 'Suco Natural', preco: 4.50, categoria: 'Bebidas' },
    // Pode colocar mais produtos se quiser...
  };
  
  // Simulação vendas
  const vendas = {
    '7891000055128': 250,  // Pão Francês
    '7891000055555': 150,  // Café com Leite
    '7891000055999': 180,  // Pão de Queijo
    '7891000055888': 90,   // Bolo de Fubá
    '7891000055777': 120,  // Sonho Recheado
    '7891000055666': 110,  // Suco Natural
  };
  
  // --- 1. Top 5 produtos mais vendidos (quantidade) ---
  const topProdutos = Object.entries(vendas)
    .sort((a,b) => b[1] - a[1])
    .slice(0, 5);
  
  const labelsTopProdutos = topProdutos.map(([codigo]) => produtos[codigo].nome);
  const dadosTopProdutos = topProdutos.map(([_, qtd]) => qtd);
  
  // --- 2. Receita por categoria ---
  const receitaPorCategoria = {};
  for (const codigo in vendas) {
    const cat = produtos[codigo].categoria;
    const receita = vendas[codigo] * produtos[codigo].preco;
    receitaPorCategoria[cat] = (receitaPorCategoria[cat] || 0) + receita;
  }
  const labelsReceitaCategoria = Object.keys(receitaPorCategoria);
  const dadosReceitaCategoria = Object.values(receitaPorCategoria);
  
  // --- 3. Receita mensal simulada ---
  const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'];
  // Simula receita total por mês (exemplo aleatório)
  const receitaMensal = meses.map(() => (Math.random()*5000 + 2000).toFixed(2));
  
  // --- Criação dos gráficos ---
  
  // Top produtos (barra)
  new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
      labels: labelsTopProdutos,
      datasets: [{
        label: 'Qtd Vendida',
        data: dadosTopProdutos,
        backgroundColor: '#3498db'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: { enabled: true }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
  
  // Receita por categoria (doughnut)
  new Chart(document.getElementById('doughnutChart'), {
    type: 'doughnut',
    data: {
      labels: labelsReceitaCategoria,
      datasets: [{
        data: dadosReceitaCategoria,
        backgroundColor: ['#27ae60', '#2980b9', '#c0392b', '#8e44ad'],
        borderColor: '#fff',
        borderWidth: 2,
        hoverOffset: 30
      }]
    },
    options: {
      cutout: '70%',
      plugins: {
        legend: { position: 'right' },
        tooltip: {
          callbacks: {
            label: ctx => `${ctx.label}: R$ ${ctx.parsed.toFixed(2).replace('.', ',')}`
          }
        }
      }
    }
  });
  
  // Receita mensal (linha)
  new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
      labels: meses,
      datasets: [{
        label: 'Receita Mensal (R$)',
        data: receitaMensal,
        borderColor: '#e67e22',
        backgroundColor: 'rgba(230, 126, 34, 0.3)',
        tension: 0.4,
        fill: true,
        pointRadius: 5,
        pointBackgroundColor: '#e67e22'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: true }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: val => `R$ ${val.toLocaleString('pt-BR')}`
          }
        }
      }
    }
  });
  