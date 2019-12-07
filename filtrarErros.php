<?php
ini_set('max_execution_time', 300);
$newHashedFile = null;
$numeroAntigo = -1;
$url = "localhost/central/erro";//url que vai fazer a requisição do cURL
//Mudar a configuração pra conseguir pegar o erro
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
            //esse V no inicio e no final é a maneira que eu encontrei de mudar o log do apache separando por Vs
            //Lembrar de colocar o código no documento do apache.
            $pos2 = strpos($linha, 'VcritV');
            $pos3 = strpos($linha,'VerrorV');
            $pos4 = strpos($linha,'VwarnV');
            $pos5 = strpos($linha,'VnoticeV');
            if($pos2 !==false||$pos3!==false ){
                
                $coisasNaLinha = explode('V',$linha);//todos os itens da linha em array
                $ultimaCoisaNaLinha = explode(':',$coisasNaLinha[5]);//ultimo item da linha, com o titulo e descrição
                $titulo = $ultimaCoisaNaLinha[0];
                $level = $coisasNaLinha[1];
                $dataHora = $coisasNaLinha[0];
                if($ultimaCoisaNaLinha[3]==null){
                    $origem = str_replace('\\\\','\\',explode('in C', $ultimaCoisaNaLinha[2]));
                }else{
                    $origem = str_replace('\\\\','\\',explode('in C', $ultimaCoisaNaLinha[3]));
                }
                $ip = explode('client ',$coisasNaLinha[4]);
                $detalhe = explode(' in C', $ultimaCoisaNaLinha[1]);
                $sendThings = array("titulo"=> $titulo, 
                                    "nivel" => $level, 
                                    "ip" => $ip[1], 
                                    "data_hora"=> $dataHora, 
                                    "origem" => $origem[0],
                                    "detalhe" => $detalhe[0],
                                    "ambiente" => "Dev");
                $sendJson = json_encode($sendThings);
                echo $sendJson;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                //attach encoded JSON string to the POST fields
                $test = curl_setopt($ch, CURLOPT_POSTFIELDS, $sendJson);
                echo "\n";
                //set the content type to application/json
                $test1 = curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE1NzYwOTM2OTEsImlhdCI6MTU3NTczMzY5MX0.OI0RXZFUhVZ9-y-48VL4_1IoZ7E3cvGBO2M9XmX6Zno'));
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

