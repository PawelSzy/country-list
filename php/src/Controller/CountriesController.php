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
     * @Route("/countries-by-name", name="countries-by-name")
     */
    public function index()
    {
        $result = $this->client->__soapCall('ListOfCountryNamesByName', []);
        return new JsonResponse((array)$result);
    }

    /**
     * @Route("/countries/{searchValue}", name="countries")
     */
    public function countries($searchValue)
    {

        $result = $this->getAllCountries();
        $result = $this->searchCountries($searchValue, $result);
        return new JsonResponse((array)$result);
    }

    private function getAllCountries()
    {
        return $this->client->__soapCall('FullCountryInfoAllCountries', []);
    }

    private function searchCountries(string $searchValue, $listOfCountries)
    {
        $countries = $listOfCountries->FullCountryInfoAllCountriesResult->tCountryInfo;

       return array_filter($countries, function($country) use ($searchValue) {
            $isCountryCode = strtoupper($country->sISOCode) === strtoupper($searchValue);
            $isCoountryName = strpos(strtoupper($country->sName), strtoupper($searchValue)) !== false;
            $language = $searchValue;
            $hasLanguage = $this->checkIfCountryHasLanguage($language, $country);
            if($isCountryCode || $isCoountryName || $hasLanguage) {
                return true;
            }
            return false;
        });
        return $listOfCountries;
    }

    private function checkIfCountryHasLanguage(string $language, $country)
    {
        if(!isset($country->Languages->tLanguage) || empty($country->Languages->tLanguage)) {
            return false;
        }
        if(is_array($country->Languages->tLanguage)) {
            $countryLanguages = $country->Languages->tLanguage;
        } else {
            $countryLanguages = [$country->Languages->tLanguage];
        }

        return !empty(array_filter($countryLanguages, function($countryLanguage) use ($language) {
            return strtoupper($countryLanguage->sName) === strtoupper($language);
        }));
    }

    /**
     * @Route("/countries-full", name="countriesFull")
     */
    public function countriesFull()
    {
        $result = $this->client->__soapCall('FullCountryInfoAllCountries', []);
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

    /**
     * @Route("/countries-by-code", name="countriesByCode")
     */
    public function countriesByCode()
    {
        $result = $this->client->__soapCall('ListOfCountryNamesByCode', []);
        return new JsonResponse((array)$result);
    }

    /**
     * @Route("/countries-by-name", name="countriesByName")
     */
    public function countriesByName()
    {
        $result = $this->client->__soapCall('ListOfCountryNamesByName', []);
        return new JsonResponse((array)$result);
    }
}
