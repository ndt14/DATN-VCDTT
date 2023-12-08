import algoliasearch from "algoliasearch/lite";
import {
  InstantSearch,
  Configure,
  SearchBox,
  Hits as InstantSearchHits,
} from "react-instantsearch-dom";
import "./css/SearchBar.css";
import React, { useState } from "react";
import { Link } from "react-router-dom";
import { useNavigate } from "react-router-dom";

const searchClient = algoliasearch(
  "ZKNG517W50",
  "f2d72a41c3b3dd95d40c9d0ac7e56434"
);

const indexName = "tours";

const SearchBar = () => {
  const [inputValue, setInputValue] = useState("");
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

  const handleChangeSynthetic = (
    event: React.SyntheticEvent<HTMLInputElement, Event>
  ) => {
    const value = (event.target as HTMLInputElement).value;
    setInputValue(value);
  };

  return (
    <>
      <InstantSearch searchClient={searchClient} indexName={indexName}>
        <Configure hitsPerPage={6} />
        <div className="search">
          <div className="my-2 fw-bold fs-4">Tìm kiếm tour:</div>
          {/* <br /> */}
          <SearchBox
            //  placeholder="Tìm kiếm..."
            onChange={handleChangeSynthetic}
            // value={inputValue}
            // onFocus={handleInputFocus}
            onSubmit={handleSearch}
            className="input-search"
          />

          <div className="search-results mt-4">
            {inputValue && <InstantSearchHits hitComponent={HitItem} />}
          </div>
        </div>
      </InstantSearch>
    </>
  );
};

const HitItem = ({ hit }: any) => {
  //slug
  const removeVietnameseSigns = (str: any) => {
    str = str.toLowerCase();
    // Chuyển đổi các ký tự có dấu thành không dấu
    str = str.replace(/á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/g, "a");
    str = str.replace(/đ/g, "d");
    str = str.replace(/é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/g, "e");
    str = str.replace(/í|ì|ĩ|ỉ|ị/g, "i");
    str = str.replace(/ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/g, "o");
    str = str.replace(/ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/g, "u");
    str = str.replace(/ý|ỳ|ỹ|ỷ|ỵ/g, "y");
    return str;
  };

  const createSlugFromString = (inputString: any) => {
    const stringWithoutVietnameseSigns = removeVietnameseSigns(inputString);
    return stringWithoutVietnameseSigns
      .replace(/\s+/g, "-")
      .replace(/[^\w\-]+/g, "")
      .replace(/\-\-+/g, "-")
      .replace(/^-+/, "")
      .replace(/-+$/, "");
  };
  return (
    <div className="mt-2">
      <Link
        to={`/tours/${hit.objectID}-${createSlugFromString(hit.name)}.html`}
      >
        <div className="d-flex">
          <div className="mr-2  my-2 h6 col-lg-5">
            <h6>{hit.name}</h6>
          </div>
          <div className="ml-2  col-lg-7">
            <img className="image" src={hit.main_img} alt="" />
          </div>
        </div>
      </Link>

      {/* Display other information about the hit here */}
    </div>
  );
};

export default SearchBar;
