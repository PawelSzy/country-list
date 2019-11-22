import React, {Component} from 'react';
import axios from 'axios';
import Countries from '../../Components/Countries/Countries'
import {Form} from 'react-bootstrap';

class CountriesListPage extends Component {
  state = {
    countries: [],
    searchPhrase: 'Poland'
  };

  componentDidMount() {
    this.getCountries();
  }

  getCountries = () => {
    const url = `http://localhost:8080/countries/${this.state.searchPhrase}`;
    axios.get(url, {crossdomain: true})
      .then(response => response.data)
      .then(data => {
        this.setState({countries: data})
        }
      )
      .catch(error => console.error(error));
  }

  handleChange = (event) => {
    this.setState({searchPhrase: event.target.value})
  }

  handleKeyUp = (event) => {
    if (event.keyCode == 13) {
      this.getCountries();
    }
  }

  render() {
    return (
      <div>
        <h1>Countries</h1>
        <Form.Control
          type="text"
          placeholder="Find country by name, code or language"
          className="col-md-4 my-4"
          onKeyUp={(e) => this.handleKeyUp(e)}
          onChange={(e) => this.handleChange(e)} />
        <Countries countries={this.state.countries}/>
    </div>
   )
  }
}

export default CountriesListPage