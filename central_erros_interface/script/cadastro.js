window.onload = function() {
    LimparMensagens();

    $('#forme').submit(function (e){
        e.preventDefault();
        EnviarCadastro();
    });
};

function EnviarCadastro(){
    LimparMensagens();

    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    var dados = '{"email":"'+inputemail.value+'", "senha":"'+inputSenha.value+'"}';
    var url = "criar_usuario";

    execAjax(
        url,
        dados, 
        'POST',
        false,
        ExibirMensagemSucesso,
        function(status, statusText) {
            ExibirMensagemFalha(statusText);
        });

    //console.dir(minhaRequisicao);
}    
