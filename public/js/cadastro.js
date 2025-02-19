$(document).ready(function () {
    // Excluir contato com confirmação
    $(".btn-excluir").click(function (event) {
        event.preventDefault();

        let contatoId = $(this).data("id");

        if (confirm("Tem certeza que deseja excluir este contato?")) {
            $.post("index.php", { excluir: true, id: contatoId }, function () {
                location.reload();
            });
        }
    });

    // Máscara para telefone e celular
    $.getScript("https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js", function () {
        $('#telefone').mask('(00) 0000-0000');
        $('#celular').mask('(00) 90000-0000');
    }); // **Correção: Fechamento correto da função `$.getScript()` aqui**

    // Validação de Nome
    $("#nome").on("input", function () {
        let nome = $(this).val();
        let regex = /^[A-ZÀ-Ÿ][a-zà-ÿ]+( [A-ZÀ-Ÿ][a-zà-ÿ]+)+$/;
        if (!regex.test(nome)) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    // Validação de Email
    $("#email").on("blur", function () {
        let email = $(this).val();
        let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!regex.test(email)) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    // Validação de Data de Nascimento
    $("#data_nascimento").on("blur", function () {
        let data = new Date($(this).val());
        let anoMinimo = 1900;
        let anoMaximo = new Date().getFullYear();
        if (data.getFullYear() < anoMinimo || data.getFullYear() > anoMaximo) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });

    // Impedir envio do formulário caso haja erros
    $("form").on("submit", function (e) {
        if ($(".is-invalid").length > 0) {
            alert("Por favor, corrija os campos inválidos antes de enviar.");
            e.preventDefault();
        }
    });
});
