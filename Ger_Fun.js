document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const resultado = document.getElementById("resultado");
    form.addEventListener("submit", function (event) {
        event.preventDefault(); 

        const nome = form.querySelector("[name='nome']").value;
        const sobrenome = form.querySelector("[name='sobrenome']").value;
        const cargo_id = form.querySelector("[name='cargo_id']").value;
        const data_nascimento = form.querySelector("[name='data_nascimento']").value;
        const salario = form.querySelector("[name='salario']").value;

        const formData = new FormData();
        formData.append("nome", nome);
        formData.append("sobrenome", sobrenome);
        formData.append("cargo_id", cargo_id);
        formData.append("data_nascimento", data_nascimento);
        formData.append("salario", salario);

        const url = "http://localhost/projeto3ml/processar_cadastro_funcionario.php"; 

        fetch(url, {
            method: "POST",
            body: formData,
        })
        .then((response) => response.text())
        .then((data) => {
            resultado.innerHTML = data;
        })
        .catch((error) => {
            console.error("Erro na solicitação AJAX:", error);
        });
    });
});
