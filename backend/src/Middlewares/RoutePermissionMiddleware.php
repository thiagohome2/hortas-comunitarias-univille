<?php

    namespace App\Middlewares;

    use App\Services\PermissaoDoUsuarioService;
    use App\Utils\Permissions\RoutePermissionMap;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Response;

    class RoutePermissionMiddleware
    {
        private RoutePermissionMap $permissionsMap;
        private PermissaoDoUsuarioService $permissaoService;

        public function __construct(
            RoutePermissionMap $permissionsMap,
            PermissaoDoUsuarioService $permissaoService
        ) {
            $this->permissionsMap = $permissionsMap;
            $this->permissaoService = $permissaoService;
        }

        public function __invoke(Request $request, RequestHandler $handler): Response
        {
            $path = $request->getUri()->getPath();
            $method = $request->getMethod();
            $routeIdentifier = $this->buildRouteIdentifier($path, $method);

            // Rotas públicas: login e cadastro
            $publicRoutes = [
                '/sessoes/login POST',
                '/sessoes/cadastro POST',
            ];

            $usuarioUuid = $request->getAttribute('usuario_uuid');

            // Se rota pública e não há JWT, seta NEW_ACCOUNT
            if (in_array($routeIdentifier, $publicRoutes, true)) {
                if (!$usuarioUuid) {
                    $request = $request->withAttribute('usuario_uuid', 'NEW_ACCOUNT');
                }
                return $handler->handle($request);
            }

            // Se não autenticado, bloqueia
            if (!$usuarioUuid) {
                $response = new Response();
                $response->getBody()->write(json_encode(['error' => 'Usuário não autenticado']));
                return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
            }

            // Verifica permissões
            $permissoesNecessarias = $this->permissionsMap->getRequiredPermissions($routeIdentifier);

            // Rota sem permissão explícita -> deixar passar
            if ($permissoesNecessarias === null) {
                return $handler->handle($request);
            }

            $payloadUsuarioLogado = [
                'usuario_uuid'    => $request->getAttribute('usuario_uuid'),
                'cargo_uuid'      => $request->getAttribute('cargo_uuid'),
                'associacao_uuid' => $request->getAttribute('associacao_uuid'),
                'horta_uuid'      => $request->getAttribute('horta_uuid'),
            ];

            $permissoesDoUsuario = $this->permissaoService->findByUuid($usuarioUuid, $payloadUsuarioLogado);

            foreach ($permissoesNecessarias as $slug) {
                if (!$permissoesDoUsuario->contains('slug', $slug)) {
                    $response = new Response();
                    $response->getBody()->write(json_encode([
                        'error' => 'Acesso negado',
                        'missing_permission' => $slug
                    ]));
                    return $response->withStatus(403)->withHeader('Content-Type', 'application/json');
                }
            }

            return $handler->handle($request);
        }

        private function buildRouteIdentifier(string $path, string $method): string
        {
            // Remove prefixo /api/v1
            $cleanPath = str_replace('/api/v1', '', $path);
            if (empty($cleanPath)) {
                $cleanPath = '/';
            }

            // Substitui UUIDs por {uuid}
            $uuidPattern = '/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/i';
            $cleanPath = preg_replace($uuidPattern, '{uuid}', $cleanPath);

            return $cleanPath . ' ' . $method;
        }
    }
