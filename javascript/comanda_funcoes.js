
    // Função para adicionar item à comanda via AJAX
    function addItemToComanda(event, form) {
        event.preventDefault();
        
        // Mostrar loading
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adicionando...';
        submitBtn.disabled = true;
        
        // Coletar todos os dados do formulário
        const formData = new FormData(form);
        formData.append('adicionar_item', 'true'); // Adicionar o nome do botão
        formData.append('ajax', 'true');
        
        fetch('comanda.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Feedback visual de sucesso
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Adicionado!';
                submitBtn.style.background = '#4CAF50';
                
                // Restaurar botão após 2 segundos
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.style.background = '';
                    submitBtn.disabled = false;
                    
                    // Resetar quantidade para 1
                    form.querySelector('input[name="quantidade"]').value = 1;
                    
                    // Limpar observações
                    form.querySelector('textarea[name="observacoes"]').value = '';
                }, 2000);
            } else {
                throw new Error('Falha ao adicionar item');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            submitBtn.innerHTML = '<i class="fas fa-times"></i> Erro';
            submitBtn.style.background = '#f44336';
            
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 2000);
            
            alert('Erro ao adicionar item. Tente novamente.');
        });
    }

    // Adicionar funcionalidade de pesquisa em tempo real para produtos
    document.addEventListener('DOMContentLoaded', function() {
        const buscaInput = document.getElementById('busca-input');
        const clearSearchBtn = document.getElementById('clear-search');
        const searchForm = document.getElementById('search-form');
        const productsContainer = document.getElementById('products-container');
        const loadingElement = document.querySelector('.loading');
        
        // Mostrar botão de limpar se houver texto na busca
        if (buscaInput && buscaInput.value) {
            clearSearchBtn.style.display = 'inline-flex';
        }
        
        // Evento para o botão de limpar busca
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', function() {
                buscaInput.value = '';
                clearSearchBtn.style.display = 'none';
                searchForm.submit();
            });
        }
        
        // Evento para mudanças no input de busca
        if (buscaInput) {
            buscaInput.addEventListener('input', function() {
                if (this.value) {
                    clearSearchBtn.style.display = 'inline-flex';
                } else {
                    clearSearchBtn.style.display = 'none';
                }
                
                // Pesquisa em tempo real com AJAX
                const searchTerm = this.value.toLowerCase();
                
                // Mostrar loading
                loadingElement.style.display = 'block';
                productsContainer.style.opacity = '0.5';
                
                // Fazer requisição AJAX
                const formData = new FormData();
                formData.append('busca', searchTerm);
                formData.append('ajax', 'true');
                
                fetch('comanda.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    // Atualizar apenas a seção de produtos
                    productsContainer.innerHTML = html;
                    
                    // Reaplicar eventos aos formulários
                    document.querySelectorAll('.product-form').forEach(form => {
                        form.onsubmit = function(e) {
                            addItemToComanda(e, this);
                        };
                    });
                    
                    // Esconder loading
                    loadingElement.style.display = 'none';
                    productsContainer.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Erro:', error);
                    // Esconder loading em caso de erro
                    loadingElement.style.display = 'none';
                    productsContainer.style.opacity = '1';
                    alert('Erro ao buscar produtos. Tente novamente.');
                });
            });
        }
        
        // Adicionar funcionalidade de pesquisa AJAX para comandas
        const comandaSearchForm = document.getElementById('comanda-search-form');
        const buscarComandasBtn = document.getElementById('buscar-comandas-btn');
        const buscaComandaInput = document.getElementById('busca-comanda-input');
        const comandasResultados = document.getElementById('comandas-resultados');
        const loadingComandas = document.querySelector('.loading-comandas');
        
        if (buscarComandasBtn && comandaSearchForm) {
            buscarComandasBtn.addEventListener('click', function() {
                buscarComandas();
            });
            
            // Também permitir pesquisa ao pressionar Enter
            buscaComandaInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    buscarComandas();
                }
            });
        }
        
        function buscarComandas() {
            const buscaTerm = buscaComandaInput.value;
            
            // Mostrar loading
            loadingComandas.style.display = 'block';
            comandasResultados.style.opacity = '0.5';
            
            // Fazer requisição AJAX
            const formData = new FormData();
            formData.append('busca_comanda', buscaTerm);
            formData.append('mostrar_comandas', '1');
            formData.append('ajax', 'true');
            
            fetch('comanda.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Atualizar apenas a seção de comandas
                comandasResultados.innerHTML = html;
                
                // Esconder loading
                loadingComandas.style.display = 'none';
                comandasResultados.style.opacity = '1';
            })
            .catch(error => {
                console.error('Erro:', error);
                // Esconder loading em caso de erro
                loadingComandas.style.display = 'none';
                comandasResultados.style.opacity = '1';
                alert('Erro ao buscar comandas. Tente novamente.');
            });
        }
    });
