<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class CreateUserController extends Controller
{
    /**
     * @var \Src\BoundedContext\User\Infrastructure\CreateUserController
     */
    private $createUserController;

    // inyectamos el controlador de la capa de infraestructura
    public function __construct(
        \Src\BoundedContext\User\Infrastructure\CreateUserController $createUserController
    ) {
        // lo inicializamos
        $this->createUserController = $createUserController;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // falta validar Request

        $newUser = new UserResource(
            $this->createUserController->__invoke($request)
        );

        return response($newUser, 201);
    }
}
