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
    });

    function mostrarErro(campo, mensagem) {
        let feedback = $(campo).next(".invalid-feedback");

        if (feedback.length === 0) {
            $(campo).after(`<small class="invalid-feedback d-block">${mensagem}</small>`);
        } else {
            feedback.text(mensagem).show();
        }
        
        $(campo).addClass("is-invalid");
    }

    function removerErro(campo) {
        $(campo).removeClass("is-invalid");
        let feedback = $(campo).next(".invalid-feedback");
        
        if (feedback.length > 0) {
            feedback.fadeOut(200, function () {
                $(this).remove();
            });
        }
    }

// Validação de Nome
    $("#nome").on("input", function () {
        let nome = $(this).val();

        nome = nome.replace(/\b\w/g, (letra) => letra.toUpperCase()).replace(/\b(de|da|do|e|von)\b/g, (letra) => letra.toLowerCase());
        $(this).val(nome);  

        let regex = /^[A-ZÀ-Ÿ][a-zà-ÿ]*(\s[A-ZÀ-Ÿ][a-zà-ÿ]+)*$/;

        if (nome === "") {
            removerErro(this); 
        } else if (!regex.test(nome)) {
            mostrarErro(this, "O nome deve conter pelo menos um sobrenome e começar com letra maiúscula.");
        } else {
            removerErro(this); 
        }
    });


    
    // Validação de Email
    $("#email").on("blur", function () {
        let email = $(this).val();
        let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (email === "") {
            removerErro(this); 
        } else if (!regex.test(email)) {
            mostrarErro(this, "Digite um email válido, como exemplo@dominio.com.");
        } else {
            removerErro(this);  
        }
    });


    // Validação de Data de Nascimento
    $("#data_nascimento").on("blur", function () {
        let data = new Date($(this).val());
        let anoMinimo = 1900;
        let anoMaximo = new Date().getFullYear();
        if (data.getFullYear() < anoMinimo || data.getFullYear() > anoMaximo) {
            mostrarErro(this, `Digite uma data válida`);
        } else {
            removerErro(this);
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
