var parametrosGet = {
    email: "",
    senha: "",
    token: ""
}

window.onload = function() {
    LimparMensagens();

    //alert(email_usuario);

    $('#email').val(email_usuario);

    parametrosGet = carregarParametros(parametrosGet);
    //console.dir(parametrosGet);

    $('#formRecovery').submit(function (e){
        e.preventDefault();
        RecuperarSenha();
    });

    $('#email').val(parametrosGet.email);
}

function RecuperarSenha(){
    LimparMensagens();
    
    var email_usuario = $('#email').val();
    var dados = '{"email":"'+email_usuario+'"}';
    var url = "usuario/esqueceu_senha";

    execAjax(
        url,
        dados, 
        'POST',
        true,
        function (statusText, data) {
            ExibirMensagemSucesso(data + " - Aguarde enquanto redirecionamos");
            setTimeout(                
                function (){                                        
                    window.location.href = "./index.php";
                },3000);
        },
        ExibirMensagemFalha
    );  
}    