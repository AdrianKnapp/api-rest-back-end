<?php
    header('Content-Type: application/json');

    require_once './vendor/autoload.php';

    $JSONError = json_encode(array('status' => 'error'), JSON_UNESCAPED_UNICODE);
    // api/users/1
    if (isset($_GET['url'])) {
        $url = explode('/', $_GET['url']);
            
        if (count($url) >= 1) {
            $service = 'App\Services\\'.ucfirst($url[0]).'Service';
            array_shift($url);

            $method = strtolower($_SERVER['REQUEST_METHOD']);
            try {
                $response = call_user_func_array(array(new $service, $method), $url);
                http_response_code(200);
                echo json_encode(array('status' => 'success', 'data' => $response));
                exit;
            } catch (Exception $e) {
                http_response_code(404);
                echo $JSONError;
                exit;
            }
        } else {
            echo $JSONError;
        }
    } else {
        echo $JSONError;
    }
    