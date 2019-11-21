<?php

namespace App\Controller;

use App\Service\Countries;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use \SoapClient;

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
     * @Route("/countries-by-name", name="countries-by-name")
     */
    public function index()
    {
        $result = $this->client->__soapCall('ListOfCountryNamesByName', []);
        return new JsonResponse((array)$result);
    }

//    /**
//     * @Route("/countries-full", name="countriesFull")
//     */
//    public function countriesFull()
//    {
//        $result = $this->client->__soapCall('FullCountryInfoAllCountries', []);
//        return new JsonResponse((array)$result);
//    }
//
//    /**
//     * @Route("/country/{sCountryISOCode}", name="country")
//     */
//    public function countryInfo($sCountryISOCode)
//    {
//        $params = array('sCountryISOCode'=> $sCountryISOCode);
////        $client->login($params);
//        $result = $this->client->__soapCall('FullCountryInfo', [$params]);
//        return new JsonResponse((array)$result);
//    }
//
//    /**
//     * @Route("/languages", name="languages")
//     */
//    public function languages()
//    {
//        $result = $this->client->__soapCall('ListOfLanguagesByName', []);
//        return new JsonResponse((array)$result);
//    }
//
//    /**
//     * @Route("/countries-by-code", name="countriesByCode")
//     */
//    public function countriesByCode()
//    {
//        $result = $this->client->__soapCall('ListOfCountryNamesByCode', []);
//        return new JsonResponse((array)$result);
//    }
//
//    /**
//     * @Route("/countries-by-name", name="countriesByName")
//     */
//    public function countriesByName()
//    {
//        $result = $this->client->__soapCall('ListOfCountryNamesByName', []);
//        return new JsonResponse((array)$result);
//    }
}
