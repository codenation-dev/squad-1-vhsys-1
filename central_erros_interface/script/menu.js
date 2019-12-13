$('#cadastro').click(function (e){
    e.preventDefault();
    window.location.href = "./cadastro.php";
});

$('#listaErros').click(function (e){
    e.preventDefault();
    window.location.href = "./tabelaErros.php";
});

window.onload = function() {
    LimparMensagens();

    if (token_session === "") {      
      ExibirMensagemFalha("Não autenticado - Aguarde enquanto redirecionamos");
      setTimeout(                
        function (){
            window.location.href = "./index.php";
        },3000
      );
    }
};