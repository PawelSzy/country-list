<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use \SoapClient;

class CountriesController extends AbstractController
{
    function __construct() {
        $this->client = new SoapClient("http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL");
    }

    /**
     * @Route("/countries", name="countries")
     */
    public function index()
    {
        $result = $this->client->__soapCall('ListOfCountryNamesByName', []);
        return new JsonResponse((array)$result);
    }


    /**
     * @Route("/country/{sCountryISOCode}", name="country")
     */
    public function countryInfo($sCountryISOCode)
    {
        $params = array('sCountryISOCode'=> $sCountryISOCode);
//        $client->login($params);
        $result = $this->client->__soapCall('FullCountryInfo', [$params]);
        return new JsonResponse((array)$result);
    }

    /**
     * @Route("/languages", name="languages")
     */
    public function languages()
    {
        $result = $this->client->__soapCall('ListOfLanguagesByName', []);
        return new JsonResponse((array)$result);
    }

}
