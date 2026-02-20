<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Projeto Picolotec API",
    version: "1.0.0",
    description: "Documentação oficial do backend do projeto Picolotec"
)]
#[OA\Server(
    url: "http://127.0.0.1",
    description: "Servidor Local"
)]
abstract class Controller
{
    //
}
