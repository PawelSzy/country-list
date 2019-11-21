<?php

namespace App\Controller;

use App\Service\Countries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
        return new JsonResponse((array)$result);
    }

    /**
     * @Route("/continents", name="continents")
     */
    public function listOfContinents()
    {
        $result = $this->countries->getAllContinents();
        return new JsonResponse((array)$result);
    }
}
