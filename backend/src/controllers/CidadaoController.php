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
            Response::send(500, ['mensagem' => 'Erro ao buscar cidadãos']);
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
                Response::send(404, ['mensagem' => 'Cidadão não encontrado']);
            }
        }catch(Exception $e){
            Response::send(500, ['mensagem' => 'Erro ao buscar cidadão']);
        }
    }

    public static function createCidadao(){
        $input = json_decode(file_get_contents('php://input'), true);
        if (!isset($input['nome'])) {
            Response::send(400, ['mensagem' => 'Argumentos inválidos: "nome" é obrigatório']);
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
            Response::send(500, ['mensagem' => 'Erro ao criar cidadão']);
        }
        
    }

    public static function updateCidadao($id){
        $input = json_decode(file_get_contents('php://input'), true);
        Response::send(501, ['mensagem'=>'Função ainda não implementada']);
    }
}