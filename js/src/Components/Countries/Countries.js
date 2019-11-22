import React from 'react'
import {Table} from 'react-bootstrap';
import './Countries.css'

const countries = (props) => (
  <Table className="mx-auto countries striped bordered hover">
    <thead className="countries__head">
      <tr>
        <th className="countries__head__element" onClick={() => props.sortFunction('sName')} data-search="countryName">Country Name</th>
        <th className="countries__head__element" onClick={() => props.sortFunction('sCapitalCity')} data-search="capital">Capital</th>
        <th className="countries__head__element" onClick={() => props.sortFunction('sContinentName')} data-search="continent">Continent</th>
        <th className="countries__head__element" onClick={() => props.sortFunction('sCurrencyName')} data-search="currency">Currency</th>
        <th className="countries__head__element" data-search="language">Languages</th>
        <th className="countries__head__element" data-search="flag">Flag</th>
      </tr>
    </thead>
    
    <tbody>
      {props.countries.map((country, countryIndex) => (
       <tr key={countryIndex}>
         <td>{country.sName}</td>
         <td>{country.sCapitalCity}</td>
         <td>{country.sContinentName}</td>
         <td>{country.sCurrencyName}</td>
         <td>
            {
              !(country.Languages.tLanguage == null)
              ? Object.values(country.Languages.tLanguage).map((language, index) => (
                <div key={index}>{language.sName}</div>
              ))
              : null
            }

         </td>
         <td><img className="country__flag" src={country.sCountryFlag} alt="country-flag" /></td>
       </tr>
      ))}
  </tbody>
  </Table>
);

export default countries;