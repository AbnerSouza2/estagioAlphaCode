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

    // Carregar a biblioteca de máscara e aplicar a máscara nos campos
    $.getScript("https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js", function () {
        $('.modal #telefone, #telefone').mask('(00) 0000-0000');
        $('.modal #celular, #celular').mask('(00) 90000-0000');
    });

    // Função para exibir mensagem de erro
    function mostrarErro(campo, mensagem) {
        let feedback = $(campo).next(".invalid-feedback");

        if (feedback.length === 0) {
            $(campo).after(`<small class="invalid-feedback d-block">${mensagem}</small>`);
        } else {
            feedback.text(mensagem).show();
        }
        $(campo).addClass("is-invalid");
    }

    // Função para remover a mensagem de erro
    function removerErro(campo) {
        $(campo).removeClass("is-invalid");
        let feedback = $(campo).next(".invalid-feedback");

        if (feedback.length > 0) {
            feedback.fadeOut(200, function () {
                $(this).remove();
            });
        }
    }

    // Validação do nome
    function validarNome(input) {
        let nome = $(input).val();

        nome = nome.replace(/\b\w/g, (letra) => letra.toUpperCase()).replace(/\b(de|da|do|e|von)\b/g, (letra) => letra.toLowerCase());
        $(input).val(nome);

        let regex = /^[A-ZÀ-Ÿ][a-zà-ÿ]+(\s[A-ZÀ-Ÿ][a-zà-ÿ]+)+$/;

        if (nome === "") {
            removerErro(input);
        } else if (!regex.test(nome)) {
            mostrarErro(input, "O nome deve conter pelo menos um sobrenome e começar com letra maiúscula.");
        } else {
            removerErro(input);
        }
    }

    // Validação do email
    function validarEmail(input) {
        let email = $(input).val().trim();
        let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (email === "") {
            removerErro(input);
        } else if (!regex.test(email)) {
            mostrarErro(input, "Digite um email válido, como exemplo@gmail.com.");
        } else {
            removerErro(input);
        }
    }

    // Validação da data de nascimento
    function validarDataNascimento(input) {
        let data = new Date($(input).val());
        let anoMinimo = 1900;
        let anoMaximo = new Date().getFullYear();
        if (data.getFullYear() < anoMinimo || data.getFullYear() > anoMaximo) {
            mostrarErro(input, "Digite uma data válida.");
        } else {
            removerErro(input);
        }
    }

    // Validação do celular
    function validarCelular(input) {
        let celular = $(input).val().trim();
        let regex = /^\(\d{2}\) 9\d{4}-\d{4}$/;

        if (celular === "") {
            removerErro(input);
        } else if (!regex.test(celular)) {
            mostrarErro(input, "Digite um número de celular válido no formato (XX) 9XXXX-XXXX.");
        } else {
            removerErro(input);
        }
    }

    // Validação ao digitar e sair do campo
    $(document).on("input", "#nome, .modal #nome", function () {
        validarNome(this);
    });

    $(document).on("blur", "#email, .modal #email", function () {
        validarEmail(this);
    });

    $(document).on("blur", "#data_nascimento, .modal #data_nascimento", function () {
        validarDataNascimento(this);
    });

    $(document).on("blur", "#celular, .modal #celular", function () {
        validarCelular(this);
    });

    // Exibição do Toast de sucesso
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('sucesso') && urlParams.get('sucesso') === '1') {
        let toastElement = document.getElementById("toastSuccess");

        if (toastElement) {
            let toast = new bootstrap.Toast(toastElement);
            toast.show();

            setTimeout(function () {
                toast.hide();
                history.replaceState(null, '', window.location.pathname);
            }, 4000);
        }
    }

    // Verificar se pode salvar no modal
    function verificarCamposModal() {
        let modal = $(".modal");
        let nome = modal.find("#nome").val().trim();
        let email = modal.find("#email").val().trim();
        let dataNascimento = modal.find("#data_nascimento").val().trim();
        let celular = modal.find("#celular").val().trim();
        let hasErrors = modal.find(".is-invalid").length > 0;
        let botaoSalvar = modal.find(".modal-salvar");

        if (nome !== "" && email !== "" && dataNascimento !== "" && celular !== "" && !hasErrors) {
            botaoSalvar.prop("disabled", false);
        } else {
            botaoSalvar.prop("disabled", true);
        }
    }

    $(document).on("input blur", ".modal #nome, .modal #email, .modal #data_nascimento, .modal #celular", function () {
        validarNome($("#nome"));
        validarEmail($("#email"));
        validarDataNascimento($("#data_nascimento"));
        validarCelular($("#celular"));
        verificarCamposModal();
    });

    $(document).on("submit", ".modal form", function (e) {
        verificarCamposModal();

        if ($(".modal .is-invalid").length > 0) {
            alert("Por favor, corrija os campos inválidos antes de salvar.");
            e.preventDefault();
        }
    });

    $(".modal").on("show.bs.modal", function () {
        verificarCamposModal();
    });
});
