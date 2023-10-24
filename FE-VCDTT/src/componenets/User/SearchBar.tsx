import algoliasearch from 'algoliasearch/lite';
import {
  InstantSearch,
  Configure,
  SearchBox,
  Hits as InstantSearchHits,
} from 'react-instantsearch-dom';
import './css/SearchBar.css';
import React, { useState } from 'react';
import { Link } from 'react-router-dom';

type Props = {};

const searchClient = algoliasearch(
  "ZKNG517W50",
  "f2d72a41c3b3dd95d40c9d0ac7e56434"
);

const indexName = 'tours';

const SearchBar = (props: Props) => {
  const [inputValue, setInputValue] = useState('');

  const handleInputFocus = () => {
    setInputValue(''); // Clear the input value to trigger suggestions
  };

  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const value = event.target.value;
    setInputValue(value);
  };

  return (
    <>
      <div className='my-2'>Tìm kiếm tour:</div>
      <br />
      <InstantSearch searchClient={searchClient} indexName={indexName}>
        <Configure hitsPerPage={5} />
        <SearchBox
          onChange={handleInputChange}
          value={inputValue}
          onFocus={handleInputFocus} // Clear input on focus
        />
        <div className="search-results">
          {inputValue && <InstantSearchHits hitComponent={HitItem} />}
        </div>
      </InstantSearch>
    </>
  );
};

const HitItem = ({ hit }: any) => {
  return (
    <div className="hit-item  my-2 ">
      <Link to={`/tours/${hit.objectID}`}>
        <div className='d-flex'>
          <div className='mr-2  my-2 h6 col-lg-5'>
          <h6 >{hit.name}</h6>
          </div>
          <div className='ml-2  col-lg-7'>
          <img className='image' src={hit.main_img} alt="" />
          </div>
          
        </div>
      </Link>
      
      {/* Display other information about the hit here */}
    </div>
  );
};

export default SearchBar;
