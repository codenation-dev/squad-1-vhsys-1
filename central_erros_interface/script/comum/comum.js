$('#identUser').text("Bem vindo "+email_usuario + ". Seu token é: " + token_session +".");

$('#sair').click(function (e){
    e.preventDefault();
    Sair();
});
$('#voltar').click(function (e){
    window.history.back();
});

function Sair(){
	$.ajax({
		url: './session_remove.php',
		type : "GET",		
		success : function(result) {
			ExibirMensagemSucesso(result);

            window.location.href = "./index.php";
		},
		error: function(xhr, resp, text) {
			ExibirMensagemFalha(text);

            window.location.href = "./index.php";
		}
	});
}

function ExibirMensagemFalha(mensagem) {
	ExibirMensagem('falha', mensagem);
}
		
function ExibirMensagemAlerta(mensagem) {
	ExibirMensagem('warning', mensagem);
}
		
function ExibirMensagemSucesso(mensagem) {
	ExibirMensagem('sucesso', mensagem);
}


function ExibirMensagem(id, mensagem) {
	LimparMensagens(id);
	
	var span_msg = document.querySelector('.msg-'+id);	

	if (span_msg) {
		span_msg.innerHTML = mensagem;
		span_msg.style.display = 'block';	
	}
}

function LimparMensagens() {
	
	LimparMensagem('falha');
	LimparMensagem('warning');
	LimparMensagem('sucesso');
}

function LimparMensagem(id) {
	
	var span_msg = document.querySelector('.msg-'+id);	

	if (span_msg) {
		span_msg.innerHTML = "";
		span_msg.style.display = 'none';	
	}
}

function carregarParametros(objParametros) {

    if (window.location.search === "") {
        return objParametros;
	}
	/*
	console.log(window.location.search);
	console.log(decodeURIComponent(window.location.search.substring(1).split("&")));
	*/
	return JSON.parse(decodeURIComponent(window.location.search.substring(1).split("&")));
}

