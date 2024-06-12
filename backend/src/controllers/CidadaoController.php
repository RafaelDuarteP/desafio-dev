<?php
require __DIR__ . '/../models/Cidadao.php';
class CidadaoController{

    public static function getCidadaos(){
        Response::send(200, ['message' => 'Not implemented yet']);
    }

    public static function getCidadao($id){
        Response::send(200, ['message' => 'Not implemented yet',
                             'id' => $id[0]]);
    }

    public static function createCidadao(){
        $input = json_decode(file_get_contents('php://input'), true);
        try {
            $nome = $input['nome'];
            $cidadao = new Cidadao($nome);
            $nis = $cidadao->createNis();
            Response::send(201, ['message' => 'Cidadão criado com sucesso',
                                 'nome' => $nome,
                                 'nis' => $nis]);
        }
        catch(Exception $e){
            Response::send(400, ['error' => 'Nome é obrigatório']);
        }
    }

    public static function updateCidadao($id){
        $input = json_decode(file_get_contents('php://input'), true);
        Response::send(200,  ['message' => 'Not implemented yet',
                                'id' => $id[0],
                                'input' => $input]);
    }
}