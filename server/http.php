<?php

$http = new swoole_http_server("0.0.0.0", 3000);

$http->set([
  'enable_static_handler' => true,
  'document_root' => "/www/swoole_demo/data"
]);

$http->on('request', function($request, $reponse) {
    $reponse->end("<h1><HTTP SERVER/h1>");
});

$http->start();
