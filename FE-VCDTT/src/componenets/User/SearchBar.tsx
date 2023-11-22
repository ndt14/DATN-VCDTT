import algoliasearch from 'algoliasearch/lite';
import {
  InstantSearch,
  Configure,
  SearchBox,
  Hits as InstantSearchHits,
} from 'react-instantsearch-dom';
import './css/SearchBar.css';
import React, { useState } from 'react';
import { Link} from 'react-router-dom';
import { useNavigate } from 'react-router-dom';




const searchClient = algoliasearch(
  "ZKNG517W50",
  "f2d72a41c3b3dd95d40c9d0ac7e56434"
);

const indexName = 'tours';

const SearchBar = () => {
  const [inputValue, setInputValue] = useState('');
  const history = useNavigate();
  // ...

  const handleSearch = () => {
    // Gửi yêu cầu tìm kiếm Algolia ở đây
    // Sử dụng giá trị `inputValue` để tìm kiếm

    // Sau khi gửi yêu cầu tìm kiếm, điều hướng đến trang tìm kiếm và truyền giá trị tìm kiếm trong URL
    history(`/search?tours%5Bquery%5D=${inputValue}`);
  };
  // const handleInputFocus = () => {
  //   setInputValue(''); // Clear the input value to trigger suggestions
  // };

  const handleChangeSynthetic = (event: React.SyntheticEvent<HTMLInputElement, Event>) => {
    const value = (event.target as HTMLInputElement).value;
    setInputValue(value);
  };

  return (
    <>
     
      <InstantSearch searchClient={searchClient} indexName={indexName}>
        <Configure hitsPerPage={6} />
        <div className="search">
        <div className='my-2'>Tìm kiếm tour:</div>
      {/* <br /> */}
        <SearchBox
        //  placeholder="Tìm kiếm..."
          onChange={handleChangeSynthetic}
          // value={inputValue}
          // onFocus={handleInputFocus} 
          onSubmit={handleSearch}
          className='input-search'
        />
        </div>
        
        <div className="search-results mt-4">
         {inputValue && <InstantSearchHits hitComponent={HitItem} />}  
        </div>
      </InstantSearch>
    </>
  );
};

const HitItem = ({ hit }: any) => {
  return (
    <div className="mt-2">
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
