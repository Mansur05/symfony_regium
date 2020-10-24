<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Mmo\Faker\PicsumProvider;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;
    private $faker;
    private $parameterBag;

    public function __construct(SluggerInterface $slugger, ParameterBagInterface $parameterBag)
    {
        $this->slugger = $slugger;

        $this->faker = Factory::create();
        $this->faker->addProvider(new PicsumProvider($this->faker)); //add faker img support (from www.picsum.photos)

        $this->parameterBag = $parameterBag;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadPosts('Science', $manager, 13);
        $this->loadPosts('COVID', $manager, 9);
        $this->loadPosts('Politics', $manager, 7);

        $this->loadPosts('Finance', $manager); //empty category
    }

    public function loadPosts(string $categoryName, ObjectManager $manager, int $count = 0)
    {
        $category = new Category();
        $category->setName($categoryName);

        for ($i = 0; $i < $count; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->sentence(5));
            $post->setDescription($this->faker->text(400));
            $post->setContent($this->faker->text(1000));
            $post->setSlug($this->slugger->slug($post->getTitle()));
            $post->setThumbnail($post->getSlug() . '.jpg');

            $thumbnail = $this->faker->picsum(null, 250, 250, true);
            file_put_contents($this->parameterBag->get('kernel.project_dir') . '/public/thumbnails/' . $post->getThumbnail(), file_get_contents($thumbnail));

            $post->setCategory($category);

            $manager->persist($post);
        }

        $manager->persist($category);

        $manager->flush();
    }
}
