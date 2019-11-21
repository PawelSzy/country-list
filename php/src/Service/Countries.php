<?php

namespace App\Service;

use \SoapClient;

class Countries
{

    private $allCountries;

    function __construct()
    {
        $this->client = new SoapClient("http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL");
    }

    public function getAllCountries(): array
    {
        if (is_null($this->allCountries)) {
            $response = $this->client->__soapCall('FullCountryInfoAllCountries', []);
            $this->allCountries = $response->FullCountryInfoAllCountriesResult->tCountryInfo ?? [];
        }
        return $this->allCountries;
    }

    public function searchCountries(string $searchValue)
    {
        $countries = $this->getAllCountries();

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
    }

    public function checkIfCountryHasLanguage(string $language, $country)
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
}