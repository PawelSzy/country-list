import React from 'react';
import logo from './logo.svg';
import './App.css';
import CountriesListPage from './Pages/CountriesListPage/CountriesListPage';
import 'bootstrap/dist/css/bootstrap.min.css';

function App() {
  return (
    <div className="App">
      <div className="container">
        <CountriesListPage />
      </div>
    </div>
  );
}

export default App;
