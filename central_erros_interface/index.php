<?php
?>
<html>
<head>
<title>Cadastro</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    

<h1>Cadastro usuario</h1>
<form action="" method="post" id="form" name="form">
    <input type="email" name="email" id="email" placeholder="e-mail"><br>
    <input type="password" name="senha" id="senha" placeholder="password">
    <input type="submit" value="Enviar">
</form>
<script src="./requisicao.js"></script>
<script type="text/javascript">


    var form = document.getElementById("form");

    form.addEventListener("submit", function(event){
        event.preventDefault();		    
        EnviarCadastro();
    });

    
    function EnviarCadastro(){
        var inputemail = document.getElementById("email");
        var inputSenha = document.getElementById("senha");

        var url = "http://localhost:8080/central/criar_usuario";
        $.ajax({
            url: url,
            crossDomain: true,
            data: form,
            dataType: 'json',
            success: function(data) {
                console.log(data);
            },
            type: 'POST'
        });
        /*
        Requisicao.ExecutarPost(
            "http://127.0.0.1:8080/central/criar_usuario",
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
        */
    }    


</script>
</body>    
</html>