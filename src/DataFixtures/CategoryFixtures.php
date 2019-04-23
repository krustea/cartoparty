<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setLabel('Aller');
        $manager->persist($category);

        $category2 = new Category();
        $category2->setLabel('Retour');
        $manager->persist($category2);

        $manager->flush();
    }
}
