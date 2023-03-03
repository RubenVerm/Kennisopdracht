<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;

class DataController extends AbstractController
{
    #[Route('/data', name: 'Kennisopdracht_data')]
    public function dataPage(): Response
    {
        $finder = new Finder();
        $finder->files()->in('C:\Users\gjver\Documents\Kennis opdracht\Kennisopdracht\data')->name('*.json');

        $packages = [];

        foreach ($finder as $file) {
            // Load the contents of the JSON file into a variable
            $jsonFile = $file->getContents();

            // Decode the JSON into an associative array
            $data = json_decode($jsonFile, true);

            // Access the installed property on the array
            $packages = array_merge($packages, $data['installed']);
        }

        return $this->render('DataPage.html.twig', [
            'data' => $packages
        ]);
    }

    // Render the template with the data

}
