         
<!-- ===========MODAL VISUALIZAR============== --> 
<div id="modalFuncionario" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="fechar">&times;</span>
        <h3>Detalhes do Funcionário</h3>
        <div class="modal-body">
            <p>
                <img id="modal-foto" src="" alt="Foto do Funcionário" style="width:120px; height:120px; object-fit:cover; border-radius:50%;">
            </p>
            <p><b>ID: </b> <span id="modal-id_funcionario"></span></p>
            <p><b>Nome: </b> <span id="modal-nome_funcionario"></span></p>
            <p><b>CPF: </b> <span id="modal-cpf_funcionario"></span></p>
            <p><b>Senha: </b> <span id="modal-senha"></span></p>
            <p><b>E-mail: </b> <span id="modal-email_funcionario"></span></p>
            <p><b>Telefone: </b> <span id="modal-telefone_funcionario"></span></p>
            <p><b>CEP: </b> <span id="modal-cep_funcionario"></span></p>
            <p><b>Rua: </b> <span id="modal-rua_funcionario"></span></p>
            <p><b>Número: </b> <span id="modal-numero_funcionario"></span></p>
            <p><b>Bairro: </b> <span id="modal-bairro_funcionario"></span></p>
            <p><b>Cidade: </b> <span id="modal-cidade_funcionario"></span></p>
            <p><b>UF: </b> <span id="modal-uf_funcionario"></span></p>
            <p><b>Data de Admissão: </b> <span id="modal-data_admissao"></span></p>
            <p><b>Salário: </b> <span id="modal-salario"></span></p>
            <p><b>Função: </b> <span id="modal-id_funcao"></span></p>
        </div>
        <div class="modal-footer">
            <a id="btn-alterar-funcionario" href="#" class="btn-alterar"><i class="ri-edit-line"></i></a>
        </div>
    </div>
</div>


<!-- MODAL ALTERAR FUNCIONÁRIO -->
<div id="modalEditarFuncionario" class="modalEditar" style="display: none;">
    <div class="container">
        <span class="fechar">&times;</span>
        <h2>Alterar Funcionário</h2>
        <form id="form-alterar-funcionario" action="../php/alterar_funcionario.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_funcionario" id="alterar-id_funcionario">

            <label>Foto:</label>
            <div class="foto-container">
                <img id="alterar-foto-preview" src="../img/avatars/default_avatar.png" alt="Preview da Foto do Funcionário">
    
                 <input type="file" name="foto_funcionario" id="alterar-foto_funcionario" accept="image/*">
    
                <label for="alterar-foto_funcionario">
                 <i class="ri-camera-line"></i> Clique para alterar
                </label>
    
                <div class="foto-instructions">Formatos: JPG, PNG • Máx: 2MB</div>
    
            <input type="hidden" name="foto_atual" id="foto_atual">
        </div>


            <label>Nome:</label>
            <input type="text" name="nome_funcionario" id="alterar-nome_funcionario" required>

            <label>CPF:</label>
            <input type="text" name="cpf_funcionario" id="alterar-cpf_funcionario" maxlength="14" required>

            <label>Senha:</label>
            <input type="password" name="senha" id="alterar-senha" placeholder="Deixe em branco para manter a atual">
            
            <label>E-mail:</label>
            <input type="email" name="email_funcionario" id="alterar-email_funcionario" required>

            <label>Telefone:</label>
            <input type="text" name="telefone_funcionario" id="alterar-telefone_funcionario" maxlength="15">

            <label>Data de Admissão:</label>
            <input type="date" name="data_admissao" id="alterar-data_admissao">

            <label>Salário:</label>
            <input type="number" name="salario" id="alterar-salario" step="0.01" min="0">

            <label>Função:</label>
            <select name="id_funcao" id="alterar-id_funcao" required>
            <option selected disabled>Selecione a Função</option>
                <?php foreach ($funcoes as $funcao): ?>
                <option value="<?= htmlspecialchars($funcao['id_funcao']) ?>" <?=$funcao['id_funcao']==$idSelecionado ? 'selected' : '' ?>>
                <?= htmlspecialchars($funcao['id_funcao'] . ' - ' . $funcao['nome_funcao']) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label>CEP:</label>
            <div class="input-container-cep">
                <input type="text" name="cep_funcionario" id="alterar-cep_funcionario" maxlength="9" placeholder="Digite o CEP (ex: 00000-000)">
                <i class="ri-search-line busca_lupa" onclick="buscarCEPFuncionario()"></i>
            </div>

            <label>Rua:</label>
            <input type="text" name="rua_funcionario" id="alterar-rua_funcionario">

            <label>Número:</label>
            <input type="text" name="numero_funcionario" id="alterar-numero_funcionario">

            <label>Bairro:</label>
            <input type="text" name="bairro_funcionario" id="alterar-bairro_funcionario">

            <label>Cidade:</label>
            <input type="text" name="cidade_funcionario" id="alterar-cidade_funcionario">

            <label>UF:</label>
            <select name="uf_funcionario" id="alterar-uf_funcionario">
                <option value="">Selecione o estado</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>

            <button type="submit" class="btn-salvar">Salvar Alterações</button>
        </form>
    </div>
</div>