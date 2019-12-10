window.onload = function() {
    LimparMensagens();
    
    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    inputemail.value = pemail;
    inputSenha.value = psenha;      
    
    $('#forme').submit(function (e){
        e.preventDefault();
        AtualizaCadastro();
    });
};

function AtualizaCadastro(){
    LimparMensagens();
    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    //var dados = '{"email":"'+inputemail.value+'","senha":"'+inputSenha.value+'","token":"'+ptoken+'"}';
    var dados = '{"email":"'+inputemail.value+'","senha":"'+inputSenha.value+'"}';
    url = "atualizar_token_usuario";
 
    execAjax(
        url,
        dados, 
        'POST',
        true,
        function (statusText, data) {
            ExibirMensagemSucesso(statusText + " - Aguarde enquanto redirecionamos");
            setTimeout(                
                function (){                    
                    var email_usuario = $('#email').val();
                    var senha_usuario = $('#senha').val();
                    var param = '?email='+email_usuario+'&senha='+senha_usuario;
                    window.location.href = "./login.php"+param;                    
                },3000
            );
        },
        function(status, statusText) {
            ExibirMensagemFalha(statusText);
        },
        true,
        ptoken
    );
}    

