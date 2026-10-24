<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Momo API",
    version: "1.0.0",
    description: "API de gestion de notes + authentification et gestion du profil utilisateur."
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
abstract class Controller
{
    //
}
