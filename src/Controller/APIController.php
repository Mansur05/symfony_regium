<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    /**
     * @Route("/api/v1/posts", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function postsV1(Request $request): Response
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findByName($request->request->get('category'));

        $posts = $category->getPosts()->toArray();
        $preparedPosts = [];

        foreach ($posts as $post) {
            $preparedPosts[] = [
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
                'image' => $post->getThumbnail(),
            ];
        }

        return $this->json($preparedPosts);
    }

    /**
     * @Route("/api/v2/posts", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function postsV2(Request $request): Response
    {
        return $this->json([
            'title' => 'Hello, World!',
            'description' => 'bla-bla-bla',
            'image' => 'photo.jpg',
        ]);
    }
}
