<?php
ini_set('max_execution_time', 300);
$newHashedFile = null;
$numeroAntigo = -1;
$url = "localhost/central/erro";

while(true){
    sleep(5);
    $hashedFile = md5_file('C:\xampp\apache\logs\error.log');
    if($hashedFile !== $newHashedFile){
        $arquivo = fopen('C:\xampp\apache\logs\error.log','r');
        $numeroAtual = 0;
        while($linha = fgets($arquivo)){
            //if para fazer o while n ter processos enquanto nao tiver novo item no log
            if($numeroAntigo > $numeroAtual){
                $numeroAtual++;
                continue;
            }
            $pos2 = strpos($linha, 'VcritV');
            $pos3 = strpos($linha,'VerrorV');
            if($pos2 !==false||$pos3!==false){
                $ch = curl_init($url);
                $coisasNaLinha = explode('V',$linha);//todos os itens da linha em array
                $ultimaCoisaNaLinha = explode(':',$coisasNaLinha[5]);//ultimo item da linha, com o titulo e descrição
                $titulo = $ultimaCoisaNaLinha[0];
                $level = $coisasNaLinha[1];
                $dataHora = $coisasNaLinha[0];
                $origem = $ultimaCoisaNaLinha[2];
                $ip = explode('client ',$coisasNaLinha[4]);
                $detalhe = explode(' in C', $ultimaCoisaNaLinha[1]);
                $sendThings = array("titulo"=> $titulo, 
                                    "nivel" => $level, 
                                    "ip" => $ip[1], 
                                    "data_hora"=> $dataHora, 
                                    "origem" => $origem,
                                    "detalhe" => $detalhe);
                $sendJson = json_encode($sendThings);
                //attach encoded JSON string to the POST fields
                curl_setopt($ch, CURLOPT_POSTFIELDS, $sendJson);
                //set the content type to application/json
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                //return response instead of outputting
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                //execute the POST request
                $result = curl_exec($ch);

                //close cURL resource
                curl_close($ch);

                $numeroAntigo = $numeroAtual;
               
                // echo "\n$numeroAtual: ". $linha . "\n";
            }
            $numeroAtual++;
        }
        $newHashedFile = md5_file('C:\xampp\apache\logs\error.log');
        fclose($arquivo);
    }
}

