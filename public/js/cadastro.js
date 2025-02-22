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

    // Função para validar o nome do usuário
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

    // Função para validar o email do usuário
    function validarEmail(input) {
        let email = $(input).val();
        let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (email === "") {
            removerErro(input);
        } else if (!regex.test(email)) {
            mostrarErro(input, "Digite um email válido, como exemplo@gmail.com.");
        } else {
            removerErro(input);
        }
    }

    // Função para validar a data de nascimento do usuário
    function validarDataNascimento(input) {
        let data = new Date($(input).val());
        let anoMinimo = 1900;
        let anoMaximo = new Date().getFullYear();
        if (data.getFullYear() < anoMinimo || data.getFullYear() > anoMaximo) {
            mostrarErro(input, `Digite uma data válida.`);
        } else {
            removerErro(input);
        }
    }

    // Validação do nome 
    $(document).on("input", "#nome, .modal #nome", function () {
        validarNome(this);
    });

    // Validação do email 
    $(document).on("blur", "#email, .modal #email", function () {
        validarEmail(this);
    });

    // Validação da data de nascimento 
    $(document).on("blur", "#data_nascimento, .modal #data_nascimento", function () {
        validarDataNascimento(this);
    });

    
    // Exibição do Toast de sucesso sem repetição 
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


 // Validação de salvar alterações somente se estiver tudo preenchido sem erros
    $(document).ready(function () {
        function verificarCamposModal() {
            let modal = $(".modal");
            let nome = modal.find("#nome").val().trim();
            let email = modal.find("#email").val().trim();
            let dataNascimento = modal.find("#data_nascimento").val().trim();
            let hasErrors = modal.find(".is-invalid").length > 0;
            let botaoSalvar = modal.find(".modal-salvar");
    
            if (nome !== "" && email !== "" && dataNascimento !== "" && !hasErrors) {
                botaoSalvar.prop("disabled", false);
            } else {
                botaoSalvar.prop("disabled", true);
            }
        }
    
        
        $(document).on("input blur", ".modal #nome, .modal #email, .modal #data_nascimento", function () {
            validarNome($("#nome"));
            validarEmail($("#email"));
            validarDataNascimento($("#data_nascimento"));
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
            $(".modal-salvar").prop("disabled", true);
        });
    });
    
});
