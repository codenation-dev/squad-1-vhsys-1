<?php

namespace Capture;
use Capture\Engine;
require_once ("Engine.php");
class Server
{
    private $engine;
    private $path;
    private $url;
    private $ambiente;
    private $token;
    private $newHashedFile;
    public function __construct()
    {

        ini_set('max_execution_time', 0);
        $this->url = "18.188.20.24/central/erro";//url que vai fazer a requisição do cURL
        $this->ambiente = readline("Digite o seu ambiente. Dev/Homologação: ");
        $this->token = readline("Digite seu token: ");
        $this->path = readline("Informe o caminho do log: ");
        $this->engine = new Engine($this->path);
    }
    public function exec(){
        while(true){
            sleep(5);
                $algumaCoisa = $this->engine->getNextLine($this->newHashedFile, $this->ambiente, $this->url, $this->token);
                echo $algumaCoisa;
                $this->newHashedFile = md5_file($this->path);
        }
    }

}