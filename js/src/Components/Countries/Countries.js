import React from 'react'
import {Table} from 'react-bootstrap';

const countries = (props) => (
  <Table className="mx-auto countries striped bordered hover">
    <thead>
      <tr>
        <th>Country Name</th>
        <th>Capital</th>
        <th>Continent</th>
        <th>Currency</th>
        <th>Languages</th>
        <th>Flag</th>
      </tr>
    </thead>
    
    <tbody>
      {Object.values(props.countries).map(country => (
       <tr>
         <td>{country.sName}</td>
         <td>{country.sCapitalCity}</td>
         <td>{country.sContinentName}</td>
         <td>{country.sCurrencyName}</td>
         <td>Languages</td>
         <td><img src={country.sCountryFlag} /></td>
       </tr>
      ))}
  </tbody>
  </Table>
);

export default countries;