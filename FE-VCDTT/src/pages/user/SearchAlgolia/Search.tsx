import React, { useState } from 'react';
import algoliasearch from 'algoliasearch/lite';
import {
  Configure,
  HierarchicalMenu,
  Highlight,
  Hits,
  InstantSearch,
  Menu,
  Pagination,
  RangeInput,
  RefinementList,
  SortBy,
  SearchBox,
  useInstantSearch,
  CurrentRefinements,
} from 'react-instantsearch';

import { Panel } from './Panel';

import type { Hit } from 'instantsearch.js';

import './Search.css';
import { Link, useLocation } from 'react-router-dom';
import { NoResultsBoundary } from './Noresults';


const searchClient = algoliasearch(
  "ZKNG517W50",
  "f2d72a41c3b3dd95d40c9d0ac7e56434"
);

export function Search() {
  const { search } = useLocation();
  console.log(search);
  
  const queryParams = new URLSearchParams(search);
  const queryParam = queryParams.get('?tours%5Bquery%5D');
  const [query, setQuery] = useState(queryParam || '');
 
 // Lấy giá trị từ Local Storage
const separatorText = localStorage.getItem('separatorText');
const submitText = localStorage.getItem('submitText');

const separator = document.querySelector(".ais-RangeInput-separator");
if (separator) {
  // Thay đổi nội dung của thẻ và lưu giá trị mới vào Local Storage
  separator.textContent = separatorText || 'Đến';
  localStorage.setItem('separatorText', separator.textContent);
}

const submit = document.querySelector(".ais-RangeInput-submit");
if (submit) {
  // Thay đổi nội dung của thẻ và lưu giá trị mới vào Local Storage
  submit.textContent = submitText || 'Tìm';
  localStorage.setItem('submitText', submit.textContent);
}

  return (
   <>
    <div>
    <section className="inner-banner-wrap">
        <div
          className="inner-baner-container"
          style={{
            backgroundImage: `url(../../../../assets/images/bg/bg1.jpg)`,
          }}
        >
          <div className="container">
            <div className="inner-banner-content">
              <h1 className="inner-title">Tìm kiếm tour</h1>
            </div>
          </div>
        </div>
        <div className="inner-shape"></div>
      </section>
      <div className="container">
      <div className="row">
      <InstantSearch searchClient={searchClient} indexName="tours" routing={true}
      insights={true}>
          <Configure hitsPerPage={6} />
              <div className="col-lg-4">
             
            <br />
              <Panel header="Vùng miền">
                <RefinementList attribute="parent_category" showMore={true} limit={5} />
              </Panel>
            
           
            <Panel header="Tỉnh">
            <HierarchicalMenu
                attributes={[
                  'category.lvl0',
                  'category.lvl1',
                  // 'hierarchicalCategories.lvl2',
                ]}
                showMore={true}
              />
              </Panel>
               <Panel header="Khoảng giá">
              <RangeInput attribute="adult_price" precision={1} />
          
            </Panel>
                </div>
                <div className="col-lg-8">
                  <div className='row my-4'>
                      <div className='col-lg-8 height'>
                      <SearchBox  placeholder="Tìm kiếm" className="searchbox" searchAsYouType={false} />
                      </div>
                      <div className='col-lg-4'>
                      <SortBy
              items={[
                { label: 'Mặc định', value: 'tours' },
                { label: 'Giá từ cao đến thấp', value: 'tours_price_asc' },
                { label: 'Giá thấp đến cao', value: 'tours_price_desc' },
              ]}
            />
</div>
    
            {/* <CurrentRefinements
              // transformItems={(items) =>
              //   items.map((item) => {
              //     const label = item.label.startsWith('hierarchicalCategories')
              //       ? 'Hierarchy'
              //       : item.label;

              //     return {
              //       ...item,
              //       attribute: label,
              //     };
              //   })
              // }
            /> */}

                  </div>
             
                <NoResultsBoundary fallback={<NoResults />}/>
                {/* <div className='row'> */}
                <Hits hitComponent={Hit}
                classNames={{
                  list: 'd-flex flex-row flex-wrap',
                  item: 'col-lg-6 p-2 w-full',
                }} />
                {/* </div> */}
             

              <div className="pagination">
                <Pagination />
              </div>
                </div> 
                </InstantSearch>
       </div>         
      
    </div>
    </div>
   </>
  
  );
}


function NoResults() {
  const { indexUiState } = useInstantSearch();

  return (
    <div>
      <p>
        Không tìm thấy kết quả cho từ khóa <q>{indexUiState.query}</q> vui lòng điền lại.
      </p>
    </div>
  );
}

type HitProps = {
  hit: Hit;
};

function Hit({ hit }: HitProps) {
  return (
    // <article>
    <div className=" " key={hit.objectID}>
    <div className="package-wrap">
      <figure className="feature-image">
        <Link to={`/tours/${hit.objectID}`}>
          <img
            className="w-full"
            src={hit.main_img}
            alt=""
          />
        </Link>
      </figure>
      <div className="package-price">
        <h6>
          <span>{hit.adult_price} đ </span> / người
        </h6>
      </div>
      <div className="package-content-wrap">
        {/* <div className="package-meta text-center"></div> */}
        <div className="package-content">
          <div className="text-container">
            <h3 className="margin-top-12 text-content">
              <Link
                className="mt-12"
                to={`/tours/${hit.objectID}`}
              >
                {hit.name}
              </Link>
            </h3>
          </div>
          <div className="review-area">
            <span className="review-text">
              ({hit.view_count} reviews)
            </span>
            <div
              className="rating-start"
              title="Rated 5 out of 5"
            >
              <span className="w-3/5"></span>
            </div>
          </div>
          <div className="text-description">
            <p className="text-content">{hit.details}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
     
      
    // </article>
  );
}
