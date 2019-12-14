var parametrosGet = {
    email: "",
    token: "",
    token_recuperacao_senha: ""
}

window.onload = function() {
    LimparMensagens();

    parametrosGet = carregarParametros(parametrosGet);
    //console.dir(parametrosGet);
    
    $('#email').val(parametrosGet.email);
        
    $('#forme').submit(function (e){
        e.preventDefault();
        AtualizaCadastro();
    });
};

function AtualizaCadastro(){
    LimparMensagens();


    if (parametrosGet.token_recuperacao_senha !== "") {
        
        var paramsTokenAux = JSON.stringify(parametrosGet);
        var urlTokenAuxiliar = "recovery?token=" + paramsTokenAux;
        
        //console.log(urlTokenAuxiliar);
        execAjax(
            urlTokenAuxiliar,
            "", 
            'GET',
            false,
            function (statusText, data2) {
                
                //ExibirMensagemSucesso(data2);

                var dados = '{"email":"'+$('#email').val()+'","senha":"'+$('#senha').val()+'"}';
                url = "atualizar_token_usuario";
            
                execAjax(
                    url,
                    dados, 
                    'POST',
                    true,
                    function (statusText, data) {
                        ExibirMensagemSucesso(data + " - Aguarde enquanto redirecionamos");
                        setTimeout(                
                            function (){                    
                                /*
                                var email_usuario = $('#email').val();
                                var senha_usuario = $('#senha').val();                                
                                var param = '?{"email":"'+email_usuario+'", "senha":"'+senha_usuario+'"}';
                                */
                                window.location.href = "./login.php?"+dados;                    
                            },5000
                        );
                    },
                    function(status, statusText) {
                        ExibirMensagemFalha(statusText);
                    },
                    true,
                    parametrosGet.token_recuperacao_senha
                );
            },
            function(status, statusText) {                
                ExibirMensagemFalha(statusText);                
            },
            true,
            parametrosGet.token_recuperacao_senha
        );  
    }
}    

