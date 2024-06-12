<?php

class Cidadao{



    private $nome;
    private $nis;

    public function __construct($nome){
        $this->nome = $nome;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getNis(){
        return $this->nis;
    }

    public function createNis(){
        $microtime = microtime();
        $microtime = str_replace(' ', '', $microtime);
        $microtime = explode('.', $microtime);
        $this->nis = substr($microtime[1], 0, 11);
        return $this->nis;
    }
}