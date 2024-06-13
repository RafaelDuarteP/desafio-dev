<?php

class DefaultController{
    public static function index(){
        Response::send(200, ['mensagem' => 'API está rodando!']);
    }
}