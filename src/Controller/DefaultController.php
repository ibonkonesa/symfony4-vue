<?php

namespace App\Controller;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('app.html.twig');
    }


    /**
     * @Route("/hello", name="hello")
     */
    public function hello(AdapterInterface $cache)
    {
        $hello = $cache->getItem('hello');

        if ($hello->isHit())
            return $this->json(false);

        $hello->set(true);
        $cache->save($hello);

        return $this->json(true);
    }

}
