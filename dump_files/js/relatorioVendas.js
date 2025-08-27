// Dados dos produtos
const produtos = {
  '7891000055128': { nome: 'Pão Francês', preco: 0.80, categoria: 'Pães' },
  '7891000055555': { nome: 'Café com Leite', preco: 3.50, categoria: 'Bebidas' },
  '7891000055999': { nome: 'Pão de Queijo', preco: 1.50, categoria: 'Pães' },
  '7891000055888': { nome: 'Bolo de Fubá', preco: 4.00, categoria: 'Bolos' },
  '7891000055777': { nome: 'Sonho Recheado', preco: 3.00, categoria: 'Doces' },
  '7891000055666': { nome: 'Suco Natural', preco: 4.50, categoria: 'Bebidas' },
  '7891000056001': { nome: 'Croissant', preco: 3.80, categoria: 'Pães' },
  '7891000056002': { nome: 'Baguete Integral', preco: 4.20, categoria: 'Pães' },
  '7891000056003': { nome: 'Pão Doce', preco: 2.50, categoria: 'Pães' },
  '7891000056004': { nome: 'Coxinha de Frango', preco: 5.00, categoria: 'Salgados' },
  '7891000056005': { nome: 'Pastel de Carne', preco: 4.80, categoria: 'Salgados' },
  '7891000056006': { nome: 'Empada de Frango', preco: 4.20, categoria: 'Salgados' },
  '7891000056007': { nome: 'Torta de Frango', preco: 6.00, categoria: 'Bolos e Tortas' },
  '7891000056008': { nome: 'Pão de Batata', preco: 2.00, categoria: 'Pães' },
  '7891000056009': { nome: 'Bolo de Cenoura', preco: 4.00, categoria: 'Bolos e Tortas' },
  '7891000056010': { nome: 'Bolo de Chocolate', preco: 4.50, categoria: 'Bolos e Tortas' },
  '7891000056011': { nome: 'Pão Integral', preco: 3.80, categoria: 'Pães' },
  '7891000056012': { nome: 'Pão de Centeio', preco: 4.00, categoria: 'Pães' },
  '7891000056013': { nome: 'Pão Multigrãos', preco: 4.50, categoria: 'Pães' },
  '7891000056014': { nome: 'Torta de Limão', preco: 5.50, categoria: 'Bolos e Tortas' },
  '7891000056015': { nome: 'Torta de Maçã', preco: 5.50, categoria: 'Bolos e Tortas' },
  '7891000056016': { nome: 'Bolo Red Velvet', preco: 6.00, categoria: 'Bolos e Tortas' },
  '7891000056017': { nome: 'Muffin de Chocolate', preco: 3.00, categoria: 'Doces' },
  '7891000056018': { nome: 'Muffin de Blueberry', preco: 3.50, categoria: 'Doces' },
  '7891000056019': { nome: 'Brownie Tradicional', preco: 4.00, categoria: 'Doces' },
  '7891000056020': { nome: 'Brownie com Nozes', preco: 4.50, categoria: 'Doces' },
  '7891000056021': { nome: 'Cookie de Chocolate', preco: 2.50, categoria: 'Doces' },
  '7891000056022': { nome: 'Cookie de Aveia', preco: 2.80, categoria: 'Doces' },
  '7891000056023': { nome: 'Pão de Leite', preco: 1.80, categoria: 'Pães' },
  '7891000056024': { nome: 'Rosquinha Açucarada', preco: 2.20, categoria: 'Doces' },
  '7891000056025': { nome: 'Rosquinha de Coco', preco: 2.40, categoria: 'Doces' },
  '7891000056026': { nome: 'Tapioca Recheada', preco: 5.00, categoria: 'Salgados' },
  '7891000056027': { nome: 'Queijadinha', preco: 2.50, categoria: 'Doces' },
  '7891000056028': { nome: 'Enroladinho de Salsicha', preco: 3.20, categoria: 'Salgados' },
  '7891000056029': { nome: 'Esfiha de Carne', preco: 4.00, categoria: 'Salgados' },
  '7891000056030': { nome: 'Esfiha de Frango', preco: 4.00, categoria: 'Salgados' },
  '7891000056031': { nome: 'Café Preto', preco: 2.00, categoria: 'Bebidas' },
  '7891000056032': { nome: 'Chá Gelado', preco: 3.00, categoria: 'Bebidas' },
  '7891000056033': { nome: 'Leite com Chocolate', preco: 3.20, categoria: 'Bebidas' },
  '7891000056034': { nome: 'Refrigerante Lata', preco: 4.50, categoria: 'Bebidas' },
  '7891000056035': { nome: 'Água Mineral 500ml', preco: 2.50, categoria: 'Bebidas' },
  '7891000056036': { nome: 'Água com Gás', preco: 3.00, categoria: 'Bebidas' },
  '7891000056037': { nome: 'Sanduíche Natural', preco: 6.00, categoria: 'Lanches e Sanduíches' },
  '7891000056038': { nome: 'Sanduíche de Atum', preco: 6.50, categoria: 'Lanches e Sanduíches' },
  '7891000056039': { nome: 'Mini Pizza', preco: 5.50, categoria: 'Lanches e Sanduíches' },
  '7891000056040': { nome: 'Bauru de Forno', preco: 6.00, categoria: 'Lanches e Sanduíches' },
  '7891000056041': { nome: 'Torrada com Alho', preco: 2.50, categoria: 'Pães' },
  '7891000056042': { nome: 'Pão com Ovo', preco: 3.80, categoria: 'Pães' },
  '7891000056043': { nome: 'Pão na Chapa', preco: 2.00, categoria: 'Pães' },
  '7891000056044': { nome: 'Crepioca', preco: 5.00, categoria: 'Salgados' },
  '7891000056045': { nome: 'Panqueca Doce', preco: 4.20, categoria: 'Bolos e Tortas' },
  '7891000056046': { nome: 'Panqueca Salgada', preco: 4.50, categoria: 'Bolos e Tortas' },
  '7891000056047': { nome: 'Mini Churros', preco: 3.00, categoria: 'Doces' },
  '7891000056048': { nome: 'Pão Recheado com Calabresa', preco: 5.50, categoria: 'Pães' },
  '7891000056049': { nome: 'Pão Recheado com Queijo', preco: 5.00, categoria: 'Pães' },
  '7891000056050': { nome: 'Pastel de Queijo', preco: 4.80, categoria: 'Salgados' }
};

// Simulação de vendas
const vendas = {
  '7891000055128': 250,
  '7891000055555': 150,
  '7891000055999': 180,
  '7891000055888': 90,
  '7891000055777': 120,
  '7891000055666': 110,
  '7891000056001': 180,
  '7891000056002': 120,
  '7891000056003': 160,
  '7891000056004': 140,
  '7891000056005': 150,
  '7891000056006': 100,
  '7891000056007': 90,
  '7891000056008': 130,
  '7891000056009': 110,
  '7891000056010': 125,
  '7891000056011': 140,
  '7891000056012': 115,
  '7891000056013': 135,
  '7891000056014': 85,
  '7891000056015': 80,
  '7891000056016': 95,
  '7891000056017': 70,
  '7891000056018': 65,
  '7891000056019': 75,
  '7891000056020': 90,
  '7891000056021': 105,
  '7891000056022': 95,
  '7891000056023': 110,
  '7891000056024': 100,
  '7891000056025': 85,
  '7891000056026': 70,
  '7891000056027': 90,
  '7891000056028': 115,
  '7891000056029': 130,
  '7891000056030': 120,
  '7891000056031': 140,
  '7891000056032': 150,
  '7891000056033': 110,
  '7891000056034': 105,
  '7891000056035': 95,
  '7891000056036': 85,
  '7891000056037': 75,
  '7891000056038': 65,
  '7891000056039': 90,
  '7891000056040': 80,
  '7891000056041': 100,
  '7891000056042': 110,
  '7891000056043': 120,
  '7891000056044': 130,
  '7891000056045': 140,
  '7891000056046': 150,
  '7891000056047': 160,
  '7891000056048': 170,
  '7891000056049': 180,
  '7891000056050': 190
};

// --- 1. Top 5 produtos mais vendidos ---
const topProdutos = Object.entries(vendas)
  .sort((a, b) => b[1] - a[1])
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
const receitaMensal = meses.map(() => (Math.random() * 5000 + 2000).toFixed(2));

// --- Criação dos gráficos ---

// Gráfico de Barras: Top produtos
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

// Gráfico Doughnut: Receita por categoria com porcentagem
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
          label: ctx => {
            const valor = ctx.parsed;
            return `${ctx.label}: R$ ${valor.toFixed(2).replace('.', ',')}`;
          }
        }
      },
      datalabels: {
        color: '#fff',
        formatter: (value, context) => {
          const dataArr = context.chart.data.datasets[0].data;
          const total = dataArr.reduce((a, b) => a + b, 0);
          const pct = (value / total * 100).toFixed(1) + '%';
          return pct;
        },
        font: {
          weight: 'bold',
          size: 10
        }
      }
    }
  },
  plugins: [ChartDataLabels]
});

// Gráfico de Linha: Receita mensal
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

// --- 4. Formas de Pagamento ---
const formasPagamento = {
  'Pix': 3500,
  'Cartão de Débito': 2200,
  'Cartão de Crédito': 2800,
  'Dinheiro': 1800,
  'Vale Alimentação': 1200
};

const labelsPagamento = Object.keys(formasPagamento);
const dadosPagamento = Object.values(formasPagamento);

// Gráfico Doughnut: Formas de Pagamento
new Chart(document.getElementById('pagamentoChart'), {
  type: 'doughnut',
  data: {
    labels: labelsPagamento,
    datasets: [{
      data: dadosPagamento,
      backgroundColor: ['#1abc9c', '#3498db', '#9b59b6', '#f39c12', '#e74c3c'],
      borderColor: '#fff',
      borderWidth: 2,
      hoverOffset: 25
    }]
  },
  options: {
    cutout: '70%',
    plugins: {
      legend: { position: 'right' },
      tooltip: {
        callbacks: {
          label: ctx => {
            const valor = ctx.parsed;
            return `${ctx.label}: R$ ${valor.toFixed(2).replace('.', ',')}`;
          }
        }
      },
      datalabels: {
        color: '#fff',
        formatter: (value, context) => {
          const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
          return ((value / total) * 100).toFixed(1) + '%';
        },
        font: {
          weight: 'bold',
          size: 10
        }
      }
    }
  },
  plugins: [ChartDataLabels]
});

