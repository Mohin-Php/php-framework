<?php
return [
    ['GET', '/', [\App\Controller\HomeController::class, 'index']],
    ['GET', '/post/{id:\d+}', [\App\Controller\HomeController::class, 'post']],
];