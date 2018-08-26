<?php
/**
 * Created by PhpStorm.
 * User: flackovic
 * Date: 26/08/2018
 * Time: 17:22
 */

namespace App\Controller;


use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends Controller
{
    /**
     * @Route("/", name="app_lucky_number")
     */
    public function test(EntityManagerInterface $em)
    {

        return new Response('<html><body>Disi</body></html>');
    }
}