var parametrosGet = {
    email: "",
    senha: ""
}
window.onload = function() {
    LimparMensagens();

    parametrosGet = carregarParametros(parametrosGet);
    console.dir(parametrosGet);

    if (token_session === "") {
      
      ExibirMensagemFalha("Não autenticado - Aguarde enquanto redirecionamos");
      setTimeout(                
        function (){
            window.location.href = "./index.php";
        },3000
      );
    } else {
        $('#forme').submit(function (e){
            e.preventDefault();
            EnviarCadastro();
        });
    }
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
        true,
        function (statusText, data) {
            ExibirMensagemSucesso(statusText + " - Aguarde enquanto redirecionamos");
            setTimeout(                
                function (){                                        
                    window.location.href = "./menu.php";
                },3000);
        },
        function(status, statusText) {
            ExibirMensagemFalha(statusText);
        },
        true,
        token_session
    );
}    
