<?php

namespace App\Controller\API\v1;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostAPIController extends AbstractController
{
    /**
     * @Route("/api/v1/posts", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function posts(Request $request): Response
    {
        if (null === $request->request->get('category'))
            return new Response('end', 400);


        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findByName($request->request->get('category'))
        ;

        if (null === $category)
            return new Response('end', 400);


        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findByCategory($category, 5)
        ;

        if (true === empty($posts))
            return new Response('end');


        $preparedPosts = [];
        foreach ($posts as $post) {
            $preparedPosts[] = [
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
                'image' => 'thumbnails/' . $post->getThumbnail(),
            ];
        }

        return $this->json($preparedPosts);
    }
}
