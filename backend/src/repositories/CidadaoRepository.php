<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Cidadao.php';
class CidadaoRepository {
    private $database;

    public function __construct() {
        $this->database = new Database();
    }

    public function findAll() {
        $cidadaos = [];
        $sql = 'SELECT * FROM cidadao';
        $result = $this->database->query($sql);
        $data =  $this->database->fetchAll($result);
        foreach ($data as $cidadao) {
            $cidadao['nome'] = $this->database->escape($cidadao['nome']);
            $cidadao['nis'] = $this->database->escape($cidadao['nis']);
            $cidadaos[] = (new Cidadao())->setNome($cidadao['nome'])->setNis($cidadao['nis']);
        }
        return $cidadaos;
    }

    public function findById($id) {
        $sql = 'SELECT * FROM cidadao WHERE nis = ?';
        $result = $this->database->query($sql,'s' ,$id);
        $data = $this->database->fetch($result);
        if($data){
            $cidadao = (new Cidadao())->setNome($data['nome'])->setNis($data['nis']);
            return $cidadao;}
        else{
            return null;
        }
    }

    public function save($cidadao) {
        $sql = 'INSERT INTO cidadao (nome, nis) VALUES (?, ?)';
        $nome = $cidadao->getNome();
        $nis = $cidadao->getNis();
        $result = $this->database->query($sql,'ss' ,$nome, $nis);
        return $cidadao;
    }
}