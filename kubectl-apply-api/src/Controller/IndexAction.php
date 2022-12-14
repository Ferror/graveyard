<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexAction
{
    #[Route('/', name: 'index')]
    public function __invoke(): Response
    {
        return new JsonResponse();
    }
}
