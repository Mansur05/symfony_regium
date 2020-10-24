<?php

namespace App\Controller\API\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/api/v1/posts", name="posts", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function posts(Request $request): Response
    {
        return $this->json([
            'title' => 'Hello, World!',
            'description' => 'bla-bla-bla',
            'image' => 'post.png',
            'category' => $request->request->get('category')
        ]);
    }
}
