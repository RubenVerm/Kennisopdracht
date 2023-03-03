<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    #[Route('/data', name: 'Kennisopdracht_data')]
    public function dataPage(): Response
    {

        // Load the contents of the JSON file into a variable
        $jsonFile = file_get_contents('C:\Users\gjver\Documents\Kennis opdracht\Kennisopdracht\data\project-1.json');

        // Decode the JSON into an associative array
        $data = json_decode($jsonFile, true);

        // Access the installed property on the array
        $packages = $data['installed'];


        return $this->render('DataPage.html.twig', [
            'data' => $packages
        ]);
    }

    // Render the template with the data

}