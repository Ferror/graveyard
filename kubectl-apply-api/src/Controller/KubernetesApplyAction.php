<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Annotation\Route;

final class KubernetesApplyAction
{
    #[Route('/kubernetes/apply', name: 'kubernetes_apply')]
    public function __invoke(): Response
    {
        $dir = dirname(__DIR__);

        $process = new Process(['kubectl', 'apply', '-f',  $dir . '/Resources/deployment.yaml', '--kubeconfig', $dir . '/Resources/config']);

        $process->run();

        if ($process->isSuccessful()) {
            return new JsonResponse([], Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(['message' => $process->getErrorOutput()], Response::HTTP_BAD_REQUEST);
    }
}
