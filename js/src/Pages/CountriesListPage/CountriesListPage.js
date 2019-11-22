import React, {Component} from 'react';
import axios from 'axios';
import Countries from '../../Components/Countries/Countries'
import {Form} from 'react-bootstrap';

class CountriesListPage extends Component {
  state = {
    countries: [],
    searchPhrase: 'Poland',
    sortOrders: {},
  };

  componentDidMount() {
    this.getCountries();
  }

  sortCountries = (sortPhrase) => {
     const dynamicSort = (property, sortOrder = 1) => {
      return function (a,b) {
        var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
        return result * sortOrder;
      }
    }

    this.setState((state, props) => {
      const newSortOrder = sortPhrase in state.sortOrders ? -1 * state.sortOrders[sortPhrase] : 1;
      const newSortOrders = {...state.sortOrder}
      newSortOrders[sortPhrase] = newSortOrder
      return {
        countries: state.countries.sort(dynamicSort(sortPhrase, newSortOrder)),
        sortOrders: newSortOrders,
      };
    });
  }

  getCountries = () => {
    const url = `http://localhost:8080/countries/${this.state.searchPhrase}`;
    axios.get(url, {crossdomain: true})
      .then(response => response.data)
      .then(data => {
        this.setState({countries: Object.values(data)})
        }
      )
      .catch(error => console.error(error));
  }

  handleChange = (event) => {
    this.setState({searchPhrase: event.target.value})
  }

  handleKeyUp = (event) => {
    if (event.keyCode === 13) {
      this.setState({countries: []})
      this.getCountries();
    }
  }

  render() {
    return (
      <div>
        <h1 className="mt-4">Countries</h1>
        <Form.Control
          type="text"
          placeholder="Find country by name, code or language"
          className="col-md-4 my-4"
          onKeyUp={(e) => this.handleKeyUp(e)}
          onChange={(e) => this.handleChange(e)} />
        <Countries countries={this.state.countries} sortFunction={this.sortCountries} />
    </div>
   )
  }
}

export default CountriesListPage