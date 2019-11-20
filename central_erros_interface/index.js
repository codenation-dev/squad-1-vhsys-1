function Consultar(){
    var url = "http://localhost/central/erro/2";
    

    console.log(url);
    Requisicao.ExecutarGet(
        url,
        '',
        false,
        function (TextoResposta) {
            try {
                console.log(TextoResposta);
            }
            catch (err) {
                console.log("Falha ao ler retorno: " + err.message)
            }
        }

    );
}

var btnCons = document.getElementById("cons"); 

btnCons.addEventListener("click", function(event){
    event.preventDefault();		    
    Consultar();
});


var form = document.getElementById("form");

form.addEventListener("submit", function(event){
    event.preventDefault();		    
    EnviarCadastro();
});


function EnviarCadastro(){
    var inputemail = document.getElementById("email");
    var inputSenha = document.getElementById("senha");

    var url = "http://localhost/central/criar_usuario";

    Requisicao.ExecutarPost(
        url,
        '{"email":"'+inputemail.value+'", "senha":"'+inputSenha.value+'"}',
        false,
        function (TextoResposta) {
            try {
                console.log(TextoResposta);
            }
            catch (err) {
                console.log("Falha ao ler retorno: " + err.message)
            }
        }
    );    
}    
