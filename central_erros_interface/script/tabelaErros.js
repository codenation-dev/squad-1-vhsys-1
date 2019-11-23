window.onload = function() {
    var url = 'http://localhost/central/erro';
    /*var myvar = '<?php echo $session_value;?>';
    alert(token_session);*/

    $.ajax({
        url: url,
        type : "GET",
        beforeSend: function(request) {
          request.setRequestHeader(
            "Authorization",
            token_session)//"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.p2lc_NG5Xay_w5gny0zQgUZz3c3Bx_Zb7d2_sUPPs84");
        }, 
        success : function(result) {
            data = JSON.parse(result);
            console.dir(data);
            //ExibirMensagemSucesso(result);

            var $table = $('#table');
            $table.bootstrapTable({data: data});

            
            $table.show();

        },
        error: function(xhr, resp, text) {

            ExibirMensagemFalha(text);

            console.log(xhr, resp, text);

            $('#table').hide();
        }
    });
};