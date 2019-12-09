window.onload = function() {
    $('#formLogin').submit(function (e){
        e.preventDefault();
        Login();
    });

    $('#linkEsqueceuSenha').click(function (e){
        e.preventDefault();
        EsqueceuSenha();
    });

    $('#email').val(pemail);
    $('#senha').val(psenha);
}

function Login(){
    
    LimparMensagens();

    var email_usuario = $('#email').val();
    var senha_usuario = $('#senha').val();
    var dados = '{"email":"'+email_usuario+'", "senha":"'+senha_usuario+'"}';
    var url = "usuario/login";

    execAjax(
        url,
        dados, 
        'POST',
        true,
        function (statusText, data) {
            //console.dir(data);
            var user = JSON.parse(data);
            
            var paramSessao = '?email='+user.email+'&token='+user.token;

            execAjax(
                './session_write.php'+paramSessao,
                "", 
                'GET',
                false,
                function (statusText) {
                    window.location.href = "./menu.php";
                },
                ExibirMensagemFalha,
                false
            );  
        },
        function(status, statusText) {
            
            ExibirMensagemFalha(statusText);

            if (status === 402) {
                window.location.href = "./cadastro.php"+paramAtualiza;
            }
        }
    );
}

function EsqueceuSenha(){
    LimparMensagens();
    
    var email_usuario = $('#email').val();
    var senha_usuario = $('#senha').val();
    var dados = '{"email":"'+email_usuario+'"}';
    var url = "usuario/esqueceu_senha";

    execAjax(
        url,
        dados, 
        'POST',
        true,
        function (statusText, data) {
            console.dir(data);
            /*var paramAtualiza = '?email='+email_usuario+'&token='+statusText;            
            window.location.href = "./atualizarCadastro.php"+paramAtualiza;
            */
        },
        ExibirMensagemFalha
    );  
}    