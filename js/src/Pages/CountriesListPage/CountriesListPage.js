import React, {Component} from 'react';
import axios from 'axios';
import Countries from '../../Components/Countries/Countries'

class CountriesListPage extends Component {
  state = {
    countries: []
  };

  componentDidMount() {
    //const url = `http://localhost:8080/countries/Korea`;
    const url = `http://localhost:8080/countries/Andorra`;
    axios.get(url, { crossdomain: true })
      .then(response => response.data)
      .then(data => {this.setState({ countries: data })
        console.log(data)}
      )
      .catch(error => console.error(error));
  }

  render() {
    return (
      <div>
        <h1>Countries</h1>

        <Countries countries={this.state.countries}/>
    </div>
  )
}
}

export default CountriesListPage