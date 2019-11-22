<?php

namespace App\Service;

use \SoapClient;

class Countries
{
    private $allCountries = [];
    private $continents = [];
    private $currencies = [];

    function __construct()
    {
        $this->client = new SoapClient("http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL");
    }

    public function getAllCountries(): array
    {
        if (empty($this->allCountries)) {
            $response = $this->client->__soapCall('FullCountryInfoAllCountries', []);
            $this->allCountries = $response->FullCountryInfoAllCountriesResult->tCountryInfo ?? [];
        }

        return $this->allCountries;
    }


    public function getAllCurrencies()
    {
        if(empty($this->currencies)) {
            $result = $this->client->__soapCall('ListOfCurrenciesByCode', []);
            $currencies = $result->ListOfCurrenciesByCodeResult->tCurrency ?? [];
            foreach ($currencies as $currency) {
                $this->currencies[(string) $currency->sISOCode] = (string) $currency->sName;
            }
        }

        return $this->currencies;
    }

    public function getCurrencyByCode(string $currencyCode): string
    {
        return $this->getAllCurrencies()[$currencyCode] ?? '';
    }

    public function getAllContinents(): array
    {
        if(empty($this->continents)) {
            $result = $this->client->__soapCall('ListOfContinentsByCode', []);
            $continents = $result->ListOfContinentsByCodeResult->tContinent ?? [];
            foreach ($continents as $continent) {
                $this->continents[(string)$continent->sCode] = (string) $continent->sName;
            }
        }

        return $this->continents;
    }

    public function getContinentByCode(string $continentCode): string
    {
        return $this->getAllContinents()[$continentCode] ?? '';
    }

    public function searchCountries(string $searchValue): array
    {
        $countries = $this->getAllCountries();

        $filteredCountries = array_filter($countries, function($country) use ($searchValue) {
            $isCountryCode = strtoupper($country->sISOCode) === strtoupper($searchValue);
            $isCoountryName = strpos(strtoupper($country->sName), strtoupper($searchValue)) !== false;
            $language = $searchValue;
            $hasLanguage = $this->checkIfCountryHasLanguage($language, $country);

            if($isCountryCode || $isCoountryName || $hasLanguage) {
                return true;
            }

            return false;
        });

        return $this->addFullDataToCountries($filteredCountries);
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

    private function addFullDataToCountries(array $countries): array
    {
        return array_map(function($country) {
            return $this->addFullDataToCountry($country);
        },$countries);
    }

    private function addFullDataToCountry($country)
    {
        $country->sContinentName = $this->getContinentByCode($country->sContinentCode);
        $country->sCurrencyName = $this->getCurrencyByCode($country->sCurrencyISOCode);

        if (is_object($country->Languages->tLanguage)) {
            $country->Languages->tLanguage = [$country->Languages->tLanguage];
        }

        return $country;
    }
}