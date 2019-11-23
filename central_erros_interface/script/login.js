$('#formLogin').submit(function (e){
    e.preventDefault();
    Login();
})

$('#linkEsqueceuSenha').click(function (e){
    e.preventDefault();
    EsqueceuSenha();
})

function Login(){
    
    LimparMensagens();

    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    var dados = '{"email":"'+inputemail.value+'", "senha":"'+inputSenha.value+'"}';
    var url = "http://localhost/central/usuario/login";

 
    //alert(url);
    
    $.ajax({
        url: url,
        type: "POST",
        async: false,
        data : dados, 
        success : function(data, textStatus, jqXHR ){
            /*
            console.dir(data);
            console.dir(textStatus);
            console.dir(jqXHR);
            */

            var user = JSON.parse(jqXHR.statusText);
            //console.dir(user);
            ExibirMensagemSucesso(jqXHR.statusText);
           
            var param = '?email='+user.email+'&token='+user.token;

            console.dir(param);

            $.ajax({
                url: './session_write.php'+param,//?usuario=' + jqXHR.statusText,
                type : "GET",
                async: false,
                success : function(result) {
                    //console.log(result);
                    ExibirMensagemSucesso(result);
                },
                error: function(xhr, resp, text) {
                    //console.log(xhr, resp, text);
                    ExibirMensagemFalha(text);
                }
            });

            //jQuery('#div_session_write').load('session_write.php?session_name=new_value');

            //header('Location:./tabelaErros.php');

            window.location.href = "./tabelaErros.php";
        },       
        
        error: function(xhr, resp, text) {
            console.dir(xhr);//"xhr: " + 

            ExibirMensagemFalha(xhr.statusText);

            
            console.dir("respXXX: " + resp);
            console.dir("textXXX: " + text);
        }
        
    });
}




function EsqueceuSenha(){
    LimparMensagens();
    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");
    var dados = '{"email":"'+inputemail.value+'"}';
    var url = "http://localhost/central/usuario/esqueceu_senha";

 
    //alert(url);
    
    $.ajax({
        url: url,
        type: "POST",
        beforeSend: function(request) {
          request.setRequestHeader(
            "Authorization",
            "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84");
        }, 
        contentType : 'application/json',
        data : dados, 

        success : function(data, textStatus, jqXHR ){
            inputSenha.value = jqXHR.statusText;
            ExibirMensagemSucesso("A senha: " + jqXHR.statusText + " deveria ter sido enviada para o e-mail cadastrado mas eu joguei ela direto para o campo Passsvord.");
        },
        
        error: function(xhr, resp, text) {
            console.dir(xhr);

            inputSenha.value = xhr.statusText;
            ExibirMensagemFalha(xhr.statusText);

            console.dir("respXXX: " + resp);
            console.dir("textXXX: " + text);
        }        
    });

    return false;
}    