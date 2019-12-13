var parametrosGet = {
    email: "",
    token: "",
    token_recuperacao_senha: ""
}

window.onload = function() {
    LimparMensagens();

    parametrosGet = carregarParametros(parametrosGet);
    //console.dir(parametrosGet);
    
    var inputemail = document.getElementById("email");
    inputemail.value = parametrosGet.email;
    
    
    $('#forme').submit(function (e){
        e.preventDefault();
        AtualizaCadastro();
    });
};

function AtualizaCadastro(){
    LimparMensagens();


    if (parametrosGet.token_recuperacao_senha !== "") {

        var base_url = "http://" + window.location.host + "/central/";
        var urlTokenAuxiliar = base_url + "recovery?token=" + parametrosGet.token_recuperacao_senha;
        var podeAtualizar = true;        

        execAjax(
            urlTokenAuxiliar,
            "", 
            'GET',
            false,
            function (statusText, data2) {
                
                /*alert(data2);
                var usuario = JSON.parse(data2);
                var paramAtualiza = '?{"email":"'+usuario.email+'", "token":"'+usuario.token+'"}';
                
                window.location.href = "./atualizarCadastro.php"+paramAtualiza;            
                */
            },
            function(status, statusText) {
                
                ExibirMensagemFalha(statusText);
                podeAtualizar = false;
            },
            false
        );  
    }

    if (podeAtualizar === false) {
        return;
    }

    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    
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
                    
                    var param = '?{"email":"'+email_usuario+'", "senha":"'+senha_usuario+'"}';
                    window.location.href = "./login.php"+param;                    
                },3000
            );
        },
        function(status, statusText) {
            ExibirMensagemFalha(statusText);
        },
        true,
        parametrosGet.token
    );
}    

