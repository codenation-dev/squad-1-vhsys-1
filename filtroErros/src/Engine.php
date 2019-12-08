<?php

namespace Capture;

class Engine
{

    public $file;
    private $lastLine = 0;
    private $ambiente;
    private $url;
    private $token;
    public function __construct($file)
    {
        if (!file_exists($file)) {
            die;
        }
        $this->file = $file;
    }

    public function getNextLine($newHashedFile, $ambiente, $url, $token)
    {
        $this->token = $token;
        $this->url = $url;
        $this->ambiente = $ambiente;

        $openedFile = $this->openFile($this->file);
        $this->lastLine = -1;//Armazena a ultima linha tratada

        $hashedFile = md5_file($this->file);

        if ($hashedFile !== $newHashedFile) {
                    $lines = file($this->file);
                    $parseErrorCatcher = strpos(end($lines), "PHP Parse error");
                    $fatalErrorCatcher = strpos(end($lines), "PHP Fatal error");
                    $warningCatcher = strpos(end($lines), "PHP Warning");
                    if ($parseErrorCatcher !== false || $warningCatcher !== false || $fatalErrorCatcher !== false) {
                        $result = end($lines);
                        return $this->splitLine($result);
                    }else{
                        $result = "NENHUM ERRO ENCONTRADO \nAGUARDANDO...\n";
                    }

        }else{
            $result = null;
        }
        $this->closeFile($openedFile);
        return $result;
    }

    public function splitLine($line){
        $splitedLine = explode("] [",$line);
        $date = explode("[",$splitedLine[0]);//Use this as a param with the index 1
        $level = explode("php7:",$splitedLine[1]);//Use this as a param with the index 1
        $splitIpAndErrorBody = explode("] ",$splitedLine[3]);
        $splitTitleAndErrorBodyItself = explode(": ",$splitIpAndErrorBody[1]);
        $title = $splitTitleAndErrorBodyItself[0];
        $errorBody = $splitTitleAndErrorBodyItself[1];
        $origem = explode(" in ", $errorBody);//Use the function end() as a param
        $ip = explode("client ",$splitIpAndErrorBody[0]);//Use this as a param with the index 1
        return $this->jsonMaker($date[1], $level[1], $errorBody, $ip[1], $title, $origem);
    }
    public function jsonMaker($date, $level, $errorBody, $ip, $title, $origem)
    {
        $arrayOfThings = array("titulo"=>$title,
                                "nivel"=>$level,
                                "ip"=>$ip,
                                "data_hora"=>$date,
                                "origem"=>end($origem),
                                "detalhe"=> $errorBody,
                                "ambiente"=>$this->ambiente);

        return $this->sendCURL(json_encode($arrayOfThings));
    }
    public function sendCURL($json){


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        //attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        echo "\n";
        //set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',"Authorization:$this->token"));
        //return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute the POST request
        $result = curl_exec($ch);
        curl_close($ch);
        if($result == true){
            return "ERRO ENCAMINHADO COM SUCESSO\n";
        }else{
            return "OCORREU ALGUM ERRO NA HORA DE ACHAR O ERRO";
        }
        //close cURL resource


    }
    public function openFile($file)
    {
        return fopen($file, 'r');
    }

    public function closeFile($file)
    {
        return fclose($file);
    }
}