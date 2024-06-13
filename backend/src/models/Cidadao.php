<?php

class Cidadao{



    private $nome;
    private $nis;

    
    public function getNome(){
        return $this->nome;
    }

    public function getNis(){
        return $this->nis;
    }

    public function setNome($nome){
        $this->nome = $nome;
        return $this;
    }

    public function setNis($nis){
        $this->nis = $nis;
        return $this;
    }

    public function createNis(){
        $microtime = microtime();
        $microtime = str_replace(' ', '', $microtime);
        $microtime = explode('.', $microtime);
        $this->nis = substr($microtime[1], 0, 11);
        return $this->nis;
    }

     public function toArray() {
        return [
            'nome' => $this->nome,
            'nis' => $this->nis,
        ];
    }
}