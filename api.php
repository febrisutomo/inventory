<?php

$files = glob('db/*.php');

foreach ($files as $file) {
    require_once($file);
}

$data = ucfirst($_GET['data']) ?? '';

$model = new $data;

$response = [];

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if(empty($_GET["id"])) {
            $response = $model->getAll();
        } else {
            $id = intval($_GET["id"]);
            $response = $model->find($id);
        }
        break;
    case 'POST':
        $request = json_decode(file_get_contents("php://input"), true);
        $response = $model->insert($request);
        break;
    case 'PUT':
        $request = json_decode(file_get_contents("php://input"), true);
        $id = intval($_GET["id"]);
        // $response = $request;
        $response = $model->update($request, $id);
        break;
    case 'DELETE':
        $id = intval($_GET["id"]);
        $response = $model->delete($id);
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

echo json_encode($response);
