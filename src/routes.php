<?php

use Gergely\SlabBackendTeszt\Fighter;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (Slim\App $app) {
    $app->get('/fighters', function (Request $request, Response $response) {
        $fighters = Fighter::all();
        $kimenet = $fighters->toJson();
        $response->getBody()->write($kimenet);
        return $response->withHeader('Content-type', 'application/json');
    });

    $app->get('/fighters/{id}', function (Request $request, Response $response, array $args) {
        if (!is_numeric($args['id']) || $args['id'] <= 0) {
            $ki = json_encode(['error' => 'Az ID-nak pozitív egész számnak kell lennie!']);
            $response->getBody()->write($ki);
            return $response->withHeader('Content-type', 'application/json')->withStatus(400);
        }
        $fighter = Fighter::find($args['id']);
        if ($fighter === null) {
            $ki = json_encode(['error' => 'Nincs ilyen ID-jű harcos.']);
            $response->getBody()->write($ki);
            return $response->withHeader('Content-type', 'application/json')->withStatus(404);
        }

        $response->getBody()->write($fighter->toJson());
        return $response->withHeader('Content-type', 'application/json')->withStatus(200);
    });

    $app->post('/fighters', function (Request $request, Response $response) {
        $input = json_decode($request->getBody(), true);
        // Bemenet validáció. egy másik órán... :(
        $fighter = Fighter::create($input);
        $fighter->save();

        $kimenet = $fighter->toJson();
        $response->getBody()->write($kimenet);
        return $response
            ->withStatus(201)
            ->withHeader('Content-type', 'application/json');
    });

    $app->delete('/fighters/{id}', function (Request $request, Response $response, array $args) {
        if (!is_numeric($args['id']) || $args['id'] <= 0) {
            $ki = json_encode(['error' => 'Az ID-nak pozitív egész számnak kell lennie!']);
            $response->getBody()->write($ki);
            return $response->withHeader('Content-type', 'application/json')->withStatus(400);
        }
        $fighter = Fighter::find($args['id']);
        if ($fighter === null) {
            $ki = json_encode(['error' => 'Nincs ilyen ID-jű harcos']);
            $response->getBody()->write($ki);
            return $response->withHeader('Content-type', 'application/json')->withStatus(404);
        }

        $fighter->delete();
        return $response->withHeader('Content-type', 'application/json')->withStatus(204);
    });

    $app->put('/fighters/{id}', function (Request $request, Response $response, array $args) {
        if (!is_numeric($args['id']) || $args['id'] <= 0) {
            $ki = json_encode(['error' => 'Az ID-nak pozitív egész számnak kell lennie!']);
            $response->getBody()->write($ki);
            return $response->withHeader('Content-type', 'application/json')->withStatus(400);
        }
        $fighter = Fighter::find($args['id']);
        if ($fighter === null) {
            $ki = json_encode(['error' => 'Nincs ilyen ID-jű harcos']);
            $response->getBody()->write($ki);
            return $response->withHeader('Content-type', 'application/json')->withStatus(404);
        }

        $input = json_decode($request->getBody(), true);
        $fighter->fill($input);
        $fighter->save();
        $response->getBody()->write($fighter->toJson());
        return $response->withHeader('Content-type', 'application/json')->withStatus(200);
    });
};
