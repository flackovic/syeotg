<?php
/**
 * Created by PhpStorm.
 * User: flackovic
 * Date: 26/08/2018
 * Time: 17:22
 */

namespace App\Controller;

use App\Entity\District;
use App\Entity\School;
use App\Entity\SchoolNetwork;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestController extends AbstractController
{
    /**
     * @Route("/generate")
     */
    public function generateOrganizationStructure(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $user = $this->getUser();

        if(!$user) {
            return new Response('<html><body>No user loged in</body></html>');
        }

        $district = new District();
        $district->setName('District name');
        $district->setAddress('District address');

        $firstSchoolNetwork = new SchoolNetwork();
        $firstSchoolNetwork->setName('First school network');
        $firstSchoolNetwork->setAddress('First school network');

        $secondSchoolNetwork = new SchoolNetwork();
        $secondSchoolNetwork->setName('Second school network');
        $secondSchoolNetwork->setAddress('Second school network');

        $thirdSchoolNetwork = new SchoolNetwork();
        $thirdSchoolNetwork->setName('Third school network');
        $thirdSchoolNetwork->setAddress('Third school network');

        $firstSchool = new School();
        $firstSchool->setName('First school');
        $firstSchool->setAddress('First school');

        $secondSchool = new School();
        $secondSchool->setName('Second school');
        $secondSchool->setAddress('Second school');

        $thirdSchool = new School();
        $thirdSchool->setName('Third school');
        $thirdSchool->setAddress('Third school');

        $district->addChildOrganization($firstSchoolNetwork);
        $district->addChildOrganization($secondSchoolNetwork);
        $district->addChildOrganization($thirdSchoolNetwork);

        $firstSchoolNetwork->addChildOrganization($firstSchool);
        $firstSchoolNetwork->addChildOrganization($secondSchool);
        $secondSchoolNetwork->addChildOrganization($thirdSchool);

        $firstSchool->addUser($user);
        $secondSchool->addUser($user);

        $em->persist($firstSchool);
        $em->persist($secondSchool);
        $em->persist($thirdSchool);

        $em->persist($firstSchoolNetwork);
        $em->persist($secondSchoolNetwork);
        $em->persist($thirdSchoolNetwork);

        $em->persist($district);

//        $em->flush();

        $result = $validator->validate($firstSchool);
        dump($result);

        return new Response('<html><body>Disi</body></html>');
    }

    /**
     * @Route("/check")
     */
    public function check(EntityManagerInterface $em)
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var PersistentCollection */
        $org = $user->getOrganization();

        dump($org);

        dump($org->getValues());



        return new Response('<html><body>Disi2</body></html>');
    }
}