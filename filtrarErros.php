<?php
//DESCONTINUADO. SCRIPT MUDA O CONFIG DO APACHE E NECESSITA DE RESET TODA HORA(NÃO USAR)
ini_set('max_execution_time', 0);
$newHashedFile = null;
$numeroAntigo = -1;
$url = "localhost/central/erro";//url que vai fazer a requisição do cURL
//Mudar a configuração pra conseguir pegar o erro
$ambiente = readline("Digite o seu ambiente. Dev/Homologação: ");
$token = readline("\rDigite seu token: ");
$caminho = readline("\rInforme o caminho do log: ");
$file = fopen("C:\\xampp\apache\conf\httpd.conf","a");
$content = str_replace("'",'"', "\nErrorLogFormat '%tV%lVpid %PV%F: %E: Vclient %aV%M'" );
$escrever = fwrite($file,$content);
fclose($file);
while(true){
    sleep(5);
    $hashedFile = md5_file($caminho);
    if($hashedFile !== $newHashedFile){
        $arquivo = fopen($caminho,'r');
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
            if($pos2 !==false||$pos3!==false ){
                $errorNotFound = strpos($linha, 'not found or unable to stat');
                if($errorNotFound!==false){
                    
                $coisasNaLinha = explode('V',$linha);//todos os itens da linha em array
                $ultimaCoisaNaLinha = explode("'",$coisasNaLinha[5]);
                $titulo = $ultimaCoisaNaLinha[0] ." ". $ultimaCoisaNaLinha[2];
                $level = $coisasNaLinha[1];
                $dataHora = $coisasNaLinha[0];
                $origem = $ultimaCoisaNaLinha[1];
                $ip = explode('client ',$coisasNaLinha[4]);
                $detalhe = $ultimaCoisaNaLinha[0]. " ". $ultimaCoisaNaLinha[1] . " " . $ultimaCoisaNaLinha[2];
                $sendThings = array("titulo"=> $titulo, 
                                    "nivel" => $level, 
                                    "ip" => $ip[1], 
                                    "data_hora"=> $dataHora, 
                                    "origem" => $origem,
                                    "detalhe" => $detalhe,
                                    "ambiente" => $ambiente);
                }else{

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
                                        "ambiente" => $ambiente);
                }
                
                
                $sendJson = json_encode($sendThings);
                echo $sendJson;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                //attach encoded JSON string to the POST fields
                $test = curl_setopt($ch, CURLOPT_POSTFIELDS, $sendJson);
                echo "\n";
                //set the content type to application/json
                $test1 = curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',"Authorization:$token"));
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
        $newHashedFile = md5_file($caminho);
        fclose($arquivo);
    }
}
