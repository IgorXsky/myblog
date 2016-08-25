<?php
namespace BlogBundle\DataFixtures\ORM;

use BlogBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BlogBundle\Entity\Post;
use Symfony\Component\Validator\Constraints\DateTime;

class LoadPostData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category = [];
        $category[1] = new Category();
        $category[2] = new Category();
        $category[3] = new Category();
        $category[4] = new Category();
        $category[5] = new Category();

        $category[1]->setName("Sport");
        $category[2]->setName("News");
        $category[3]->setName("Business");
        $category[4]->setName("It");
        $category[5]->setName("Music");

        $manager->persist($category[1]);
        $manager->persist($category[2]);
        $manager->persist($category[3]);
        $manager->persist($category[4]);
        $manager->persist($category[5]);

        for ($i = 1; $i < 200; $i++) {
            $date = new \DateTime();
            $date->sub(new \DateInterval('P' . rand(1, 999) . 'D'));
            $post = new Post();
            $post->setTitle('Some random post ' . rand(1, 999999));
            $post->setContent('Lorem Ipsum - це текст-"риба", що використовується в друкарстві та дизайні. Lorem Ipsum є, фактично, стандартною "рибою" аж з XVI сторіччя, коли невідомий друкар взяв шрифтову гранку та склав на ній підбірку зразків шрифтів. "Риба" не тільки успішно пережила п\'ять століть, але й прижилася в електронному верстуванні, залишаючись по суті незмінною. Вона популяризувалась в 60-их роках минулого сторіччя завдяки виданню зразків шрифтів Letraset, які містили уривки з Lorem Ipsum, і вдруге - нещодавно завдяки програмам комп\'ютерного верстування на кшталт Aldus Pagemaker, які використовували різні версії Lorem Ipsum.');
            $post->setImage(rand(1, 10).'.jpg');
            $post->setCreatedAt($date);
            $post->setCategory($category[rand(1,5)]);
            $manager->persist($post);
        }
        $manager->flush();
    }
}
