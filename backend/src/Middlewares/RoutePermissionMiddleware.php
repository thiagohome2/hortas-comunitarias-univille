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

        // echo "========================== INFORMAÇÕES DA ROTA ATUAL:\n";
        // echo "URI: " . $path . "\n";
        // echo "Method: " . $method . "\n";

        // Pular validação para rota de login
        if ($path === '/api/v1/sessoes' && $method === 'POST') {
            return $handler->handle($request);
        }

        // Construir identificador da rota removendo o prefixo /api/v1
        $routeIdentifier = $this->buildRouteIdentifier($path, $method);
        // echo "Route Identifier: " . $routeIdentifier . "\n";

        $usuarioUuid = $request->getAttribute('usuario_uuid');

        if (!$usuarioUuid) {
            $response = new Response();
            $response->getBody()->write(json_encode(['error' => 'Usuário não autenticado']));
            return $response->withStatus(401);
        }

        $permissoesNecessarias = $this->permissionsMap->getRequiredPermissions($routeIdentifier);

        // echo "========================== PERMISSOES NECESSARIAS:\n";
        // if (is_array($permissoesNecessarias)) {
        //     foreach ($permissoesNecessarias as $perm) {
        //         echo "- " . $perm . "\n";
        //     }
        // } else {
        //     echo $permissoesNecessarias . "\n";
        // }
                
        if ($permissoesNecessarias === null) {
            // rota sem permissão explícita -> deixar passar
            return $handler->handle($request);
        }
        
        $permissoesDoUsuario = $this->permissaoService->findByUuid($usuarioUuid);
        
        // echo "========================== PERMISSOES DO USUARIO:\n";
        // foreach ($permissoesDoUsuario as $perm) {
        //     // Se $perm for um objeto Eloquent, pode usar a propriedade slug ou uuid
        //     echo "- " . ($perm->slug ?? $perm->uuid ?? json_encode($perm)) . "\n";
        // }

        foreach ($permissoesNecessarias as $slug) {
            if (!$permissoesDoUsuario->contains('slug', $slug)) {
                $response = new Response();
                $response->getBody()->write(json_encode([
                    'error' => 'Acesso negado',
                    'missing_permission' => $slug
                ]));
                return $response->withStatus(403);
            }
        }

        return $handler->handle($request);
    }

    /**
     * Constrói o identificador da rota a partir da URI e método
     * Remove o prefixo /api/v1 e tenta fazer match com padrões de UUID
     */
    private function buildRouteIdentifier(string $path, string $method): string
    {
        // Remove o prefixo /api/v1
        $cleanPath = str_replace('/api/v1', '', $path);
        
        // Se path vazio, usar raiz
        if (empty($cleanPath)) {
            $cleanPath = '/';
        }

        // Substituir UUIDs por {uuid} pattern
        $cleanPath = $this->replaceUuidsWithPattern($cleanPath);

        return $cleanPath . ' ' . $method;
    }

    /**
     * Substitui UUIDs reais por padrão {uuid} para fazer match com o mapeamento
     */
    private function replaceUuidsWithPattern(string $path): string
    {
        // Regex para UUID: 8-4-4-4-12 caracteres hexadecimais
        $uuidPattern = '/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/i';
        
        return preg_replace($uuidPattern, '{uuid}', $path);
    }
}