<?php
require_once __DIR__ . '/../models/Cidadao.php';
require_once __DIR__ . '/../repositories/CidadaoRepository.php';
class CidadaoController{

    public static function getCidadaos(){
        try
        {
            $cidadaoRepository = new CidadaoRepository();
            $cidadaos = $cidadaoRepository->findAll();
            $response = [];

            foreach($cidadaos as $cidadao){
                $response[] = $cidadao->toArray();
            }
            Response::send(200, $response);
        }catch(Exception $e){         
            Response::send(500);
        }
    }

    public static function getCidadao($id){
        try
        {
            $cidadaoRepository = new CidadaoRepository();
            $cidadao = $cidadaoRepository->findById($id[0]);
            if($cidadao){
                Response::send(200, $cidadao->toArray());
            }else{
                Response::send(404, ['error' => 'Cidadão não encontrado']);
            }
        }catch(Exception $e){
            Response::send(500);
        }
    }

    public static function createCidadao(){
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['nome'])) {
            Response::send(400, ['error' => 'Nome é obrigatório']);
        }
        try{
            $nome = $input['nome'];
            $cidadao = new Cidadao();
            $cidadao->setNome($nome);
            $cidadao->createNis();
            $cidadaoRepository = new CidadaoRepository();
            $cidadaoRepository->save($cidadao);
            Response::send(201, $cidadao->toArray());
        }catch(Exception $e){
            Response::send(500);
        }
        
    }

    public static function updateCidadao($id){
        $input = json_decode(file_get_contents('php://input'), true);
        Response::send(200,  ['message' => 'Not implemented yet',
                                'id' => $id[0],
                                'input' => $input]);
    }
}