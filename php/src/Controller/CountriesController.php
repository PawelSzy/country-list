<?php

namespace App\Controller;

use App\Service\Countries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class CountriesController extends AbstractController
{
    function __construct(Countries $countries) {
        $this->countries = $countries;
    }

    /**
     * @Route("/countries/{searchValue}", name="countries")
     */
    public function countries($searchValue)
    {
        $result = $this->countries->searchCountries($searchValue);

        $response = new JsonResponse((array) $result);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @Route("/continents", name="continents")
     */
    public function listOfContinents()
    {
        $result = $this->countries->getAllContinents();

        $response = new JsonResponse((array) $result);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
