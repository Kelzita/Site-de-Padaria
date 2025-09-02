document.addEventListener("DOMContentLoaded", () => {

    document.body.addEventListener("click", (e) => {
        if (e.target.classList.contains("btn-remover-item")) {
            if (!confirm("Tem certeza que deseja remover este produto do carrinho?")) {
                e.preventDefault();
            }
        }
    });

    document.querySelectorAll("form").forEach(form => {
        form.addEventListener("submit", (e) => {
            let mensagens = [];
            const qtd = form.querySelector('input[name="quantidade"]');
            const obs = form.querySelector('textarea[name="observacoes"]');

            if (qtd && (qtd.value === "" || qtd.value <= 0)) {
                mensagens.push("A quantidade deve ser maior que 0.");
                qtd.classList.add("erro");
            } else if (qtd) {
                qtd.classList.remove("erro");
            }

            if (obs && obs.value.length > 200) {
                mensagens.push("A observação não pode ter mais que 200 caracteres.");
                obs.classList.add("erro");
            } else if (obs) {
                obs.classList.remove("erro");
            }

            if (mensagens.length) {
                e.preventDefault();
                alert(mensagens.join("\n"));
            }
        });
    });

});
