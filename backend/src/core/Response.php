<?php

class Response {
    public static function send($status, $data = null) {
        header('Content-Type: application/json');
        http_response_code($status);
        if (!is_null($data)) {
            echo json_encode($data);
        }
        exit();
    }
}