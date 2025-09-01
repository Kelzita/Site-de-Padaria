<!-- MODAL DE VISUALIZAR FORNECEDOR -->
 
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="fechar">&times;</span>
        <h3>Detalhes do Fornecedor</h3>
        <div class="modal-body">
            <p><b>ID: </b> <span id="modal-id"></span></p>
            <p><b>Razão Social: </b> <span id="modal-razao_social"></span></p>
            <p><b>Responsável: </b> <span id="modal-responsavel"></span></p>
            <p><b>CNPJ: </b> <span id="modal-cnpj_fornecedor"></span></p>
            <p><b>E-mail: </b> <span id="modal-email_fornecedor"></span></p>
            <p><b>Telefone: </b> <span id="modal-telefone_fornecedor"></span></p>
            <p><b>CEP: </b> <span id="modal-cep_fornecedor"></span></p>
            <p><b>Rua: </b> <span id="modal-rua_fornecedor"></span></p>
            <p><b>Número: </b> <span id="modal-numero_fornecedor"></span></p>
            <p><b>Bairro: </b> <span id="modal-bairro_fornecedor"></span></p>
            <p><b>Cidade: </b> <span id="modal-cidade_fornecedor"></span></p>
            <p><b>UF: </b> <span id="modal-uf_fornecedor"></span></p>
        </div>
        <div class="modal-footer">
            <a id="btn-alterar" href="#" class="btn-alterar"><i class="ri-edit-line"></i></a>
        </div>
    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal");
    const fecharBtns = modal.querySelectorAll(".fechar, .btn-fechar");
    const btnAlterar = document.getElementById("btn-alterar");

    document.querySelectorAll(".visualizar").forEach(botao => {
        botao.addEventListener("click", e => {
            e.preventDefault();

            // Preenche dados
            document.getElementById("modal-id").textContent = botao.dataset.id;
            document.getElementById("modal-razao_social").textContent = botao.dataset.razao;
            document.getElementById("modal-responsavel").textContent = botao.dataset.responsavel;
            document.getElementById("modal-cnpj_fornecedor").textContent = botao.dataset.cnpj_fornecedor;
            document.getElementById("modal-email_fornecedor").textContent = botao.dataset.email_fornecedor;
            document.getElementById("modal-telefone_fornecedor").textContent = botao.dataset.telefone_fornecedor;
            document.getElementById("modal-cep_fornecedor").textContent = botao.dataset.cep_fornecedor;
            document.getElementById("modal-rua_fornecedor").textContent = botao.dataset.rua_fornecedor;
            document.getElementById("modal-numero_fornecedor").textContent = botao.dataset.numero_fornecedor;
            document.getElementById("modal-bairro_fornecedor").textContent = botao.dataset.bairro_fornecedor;
            document.getElementById("modal-cidade_fornecedor").textContent = botao.dataset.cidade_fornecedor;
            document.getElementById("modal-uf_fornecedor").textContent = botao.dataset.uf_fornecedor;

            // Atualiza link de alterar
            btnAlterar.href = "alterar_fornecedor.php?id=" + botao.dataset.id;

            modal.style.display = "flex";
        });
    });

    // Fechar modal
    fecharBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            modal.style.display = "none";
        });
    });

    window.addEventListener("click", e => {
        if (e.target === modal) modal.style.display = "none";
    });
});
</script>


<!-- ALTERAR FORNECEDOR -->

<div id="modal-alterar" class="modal">
    <div class="modal-content">
        <span class="fechar">&times;</span>
        <h3>Alterar Fornecedor</h3>
        <form id="form-alterar" action="../php/salvar_alteracao.php" method="POST">
            <input type="hidden" name="id_fornecedor" id="alterar-id">

            <label>Razão Social:</label>
            <input type="text" name="razao_social" id="alterar-razao_social">

            <label>Responsável:</label>
            <input type="text" name="responsavel" id="alterar-responsavel">

            <label>CNPJ:</label>
            <input type="text" name="cnpj_fornecedor" id="alterar-cnpj_fornecedor">

            <label>E-mail:</label>
            <input type="email" name="email_fornecedor" id="alterar-email_fornecedor">

            <label>Telefone:</label>
            <input type="text" name="telefone_fornecedor" id="alterar-telefone-fornecedor">

            <label>CEP:</label>
            <input type="text" name="cep_fornecedor" id="alterar-cep_fornecedor">

            <label>Rua:</label>
            <input type="text" name="rua_fornecedor" id="alterar-rua_fornecedor">

            <label>Número:</label>
            <input type="text" name="numero_fornecedor" id="alterar-numero_fornecedor">

            <label>Bairro:</label>
            <input type="text" name="bairro_fornecedor" id="alterar-bairro_fornecedor">

            <label>Cidade:</label>
            <input type="text" name="cidade_fornecedor" id="alterar-cidade_fornecedor">

            <label>UF:</label>
            <input type="text" name="uf_fornecedor" id="alterar-uf_fornecedor">

            <div class="modal-footer">
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<script>

document.addEventListener("DOMContentLoaded", () => {
    const modalAlterar = document.getElementById("modal-alterar");
    const fecharAlterar = modalAlterar.querySelector(".fechar");

    document.querySelectorAll(".alterar").forEach(botao => {
        botao.addEventListener("click", e => {
            e.preventDefault();

            // Preenche modal de alteração
            document.getElementById("alterar-id").value = botao.dataset.id;
            document.getElementById("alterar-razao_social").value = botao.dataset.razao_social;
            document.getElementById("alterar-responsavel").value = botao.dataset.responsavel;
            document.getElementById("alterar-cnpj_fornecedor").value = botao.dataset.cnpj_fornecedor;
            document.getElementById("alterar-email_fornecedor").value = botao.dataset.email_fornecedor;
            document.getElementById("alterar-telefone-fornecedor").value = botao.dataset.telefone_fornecedor;
            document.getElementById("alterar-cep_fornecedor").value = botao.dataset.cep_fornecedor;
            document.getElementById("alterar-rua_fornecedor").value = botao.dataset.rua_fornecedor;
            document.getElementById("alterar-numero_fornecedor").value = botao.dataset.numero_fornecedor;
            document.getElementById("alterar-bairro_fornecedor").value = botao.dataset.bairro_fornecedor;
            document.getElementById("alterar-cidade_fornecedor").value = botao.dataset.cidade_fornecedor;
            document.getElementById("alterar-uf_fornecedor").value = botao.dataset.uf_fornecedor;

            // Abre modal de alteração
            modalAlterar.style.display = "flex";
        });
    });

    // Fechar modal
    fecharAlterar.addEventListener("click", () => {
        modalAlterar.style.display = "none";
    });

    window.addEventListener("click", e => {
        if (e.target === modalAlterar) modalAlterar.style.display = "none";
    });
});
</script>


