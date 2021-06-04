<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/our-wines", name="wines")
     */
    public function wines()
    {
        $database = new \Filebase\Database([
            'dir' => $this->get('kernel')->getProjectDir() . '/var/database/wines',
        ]);

        $wines = $database->findAll(true, true);

        return $this->render(
            'wines/index.html.twig',
            [
                'wines' => $wines,
            ]
        );
    }

    /**
     * @Route("/our-wines/{slug}", name="wine")
     */
    public function wine($slug)
    {
        $database = new \Filebase\Database([
            'dir' => $this->get('kernel')->getProjectDir() . '/var/database/wines',
        ]);

        $wine = $database->query()->where('slug', '=', $slug)->first();

        if ($wine === false) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'wines/entry.html.twig',
            [
                'wine' => $wine,
            ]
        );
    }
}
