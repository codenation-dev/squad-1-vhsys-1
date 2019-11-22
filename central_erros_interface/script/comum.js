
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
    
    //console.log("mensagem " + mensagem);

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