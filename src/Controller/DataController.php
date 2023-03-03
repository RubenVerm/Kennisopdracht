<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;

class DataController extends AbstractController
{


    #[Route('/data', name: 'Kennisopdracht_data')]
    public function dataPage(Request $request): Response
    {
        $finder = new Finder();
        $finder->files()->in('C:\Users\gjver\Documents\Kennis opdracht\Kennisopdracht\data')->name('*.json');

        $packages = [];


        // Load the contents of the JSON file into a variable
        // Decode the JSON into an associative array
        // Access the installed property on the array
        foreach ($finder as $file) {
            
            $jsonFile = $file->getContents();

            $data = json_decode($jsonFile, true);
            
            $packages = array_merge($packages, $data['installed']);
        }

        // Get the filter and sort parameters from the query string
        $filter = $request->query->get('filter');
        $sort = $request->query->get('sort');

        // Apply the filter, if set
        if (!empty($filter)) {
            $packages = array_filter($packages, function ($package) use ($filter) {
                return strpos($package['name'], $filter) !== false;
            });
        }

        // Apply the sort, if set
        if (!empty($sort)) {
            usort($packages, function ($a, $b) use ($sort) {
                if ($sort === 'version_asc') {
                    return version_compare($a['version'], $b['version']);
                } elseif ($sort === 'version_desc') {
                    return version_compare($b['version'], $a['version']);
                }
            });
        }

        return $this->render('DataPage.html.twig', [
            'data' => $packages,
            'filter' => $filter,
            'sort' => $sort
        ]);
    }
}
