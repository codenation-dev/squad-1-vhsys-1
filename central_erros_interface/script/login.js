var parametrosGet = {
    email: "",
    senha: ""
}

window.onload = function() {
    LimparMensagens();

    //alert(email_usuario);

    $('#email').val(email_usuario);

    parametrosGet = carregarParametros(parametrosGet);
    //console.dir(parametrosGet);

    $('#formLogin').submit(function (e){
        e.preventDefault();
        Login();
    });

    $('#linkEsqueceuSenha').click(function (e){
        e.preventDefault();
        EsqueceuSenha();
    });

    $('#email').val(parametrosGet.email);
    $('#senha').val(parametrosGet.senha);
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
            
            var paramSessao = '?email='+user.email+'&token='+user.token+'&lembrarDeMim='+$('#lembrarDeMim').prop('checked');
            
            execAjax(
                './session_write.php'+paramSessao,
                "", 
                'GET',
                false,
                function (statusText, data) {
                    //alert(data);
                    
                    window.location.href = "./menu.php";
                },
                ExibirMensagemFalha,
                false
            );  
        },
        function(status, statusText, responseText) {


            if (status === 401) {
                ExibirMensagemFalha("Autenticação não encontrada, entre em contato com o adm.");
            } else if (status === 402) {
                ExibirMensagemFalha("Autenticação inválida, entre em contato com o adm.");
            } else if (status === 403) {
                ExibirMensagemFalha("Autenticação expirada, por favor atualize seu cadastro.");
                
                //EsqueceuSenha();
            } else {
                ExibirMensagemFalha;
            }

            /*
            var tok = JSON.parse(responseText);
            
            var paramAtualiza = '?{"email":"'+email_usuario+'", "token":"'+tok.token+'"}';
            console.dir(paramAtualiza);
            ExibirMensagemFalha("AutenticaÃ§Ã£o expirada, por favor atualize seu cadastro.");

            if (status === 403) {
                
                
                setTimeout(                
                    function (){
                        
                        window.location.href = "./atualizarCadastro.php"+paramAtualiza;
                    },3000
                  );
            }
            */
         }
    );
}

function EsqueceuSenha(){
    LimparMensagens();
    
    window.location.href = "./recovery.php";

    /*
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
            
            //console.log(data);
            var url2 = JSON.parse(decodeURIComponent(data));            
            
            execAjax(
                url2.url,
                "", 
                'GET',
                false,
                function (statusText, data2) {
            
                    var usuario = JSON.parse(data2);
                    
                    var paramAtualiza = '?{"email":"'+usuario.email+'", "token":"'+usuario.token+'"}';
                    
                    window.location.href = "./atualizarCadastro.php"+paramAtualiza;            
                },
                function(status, statusText) {
                    
                    ExibirMensagemFalha(statusText);
                },
                false
            );  
        },
        ExibirMensagemFalha
    );  
    */
}    