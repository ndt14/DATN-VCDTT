import React from 'react';
import algoliasearch from 'algoliasearch/lite';
import {
  Configure,
  Highlight,
  Hits,
  InstantSearch,
  Pagination,
  RangeInput,
  RefinementList,
  SearchBox,
} from 'react-instantsearch';

import { Panel } from './Panel';

import type { Hit } from 'instantsearch.js';

import './Search.css';
import { Link } from 'react-router-dom';

const searchClient = algoliasearch(
  "ZKNG517W50",
  "f2d72a41c3b3dd95d40c9d0ac7e56434"
);

export function Search() {
  return (
   <>
    <div>
      <div className="container">
      <div className="row">
      <InstantSearch searchClient={searchClient} indexName="tours_to_categories" >
          <Configure hitsPerPage={8} />
              <div className="col-lg-4">
              <Panel header="brand">
                <RefinementList attribute="cate_name" showMore={true} limit={5}/>
              </Panel>
              <Panel header="Price">
              <RangeInput attribute="child_price" precision={1}  />
            </Panel>
                </div>
                <div className="col-lg-8">
                <SearchBox placeholder="" className="searchbox" />
              <Hits hitComponent={Hit} />

              <div className="pagination">
                <Pagination />
              </div>
                </div>  
                </InstantSearch>
       </div>         
        
   


       
          {/* <div className="search-panel">
            <div className="search-panel__filters">
              <Panel header="brand">
                <RefinementList attribute="cate_name" showMore={true} limit={5}/>
              </Panel>
              <Panel header="Price">
              <RangeInput attribute="child_price" precision={1}  />
            </Panel>
            </div>
            
            <div className="search-panel__results">
              <SearchBox placeholder="" className="searchbox" />
              <Hits hitComponent={Hit} />

              <div className="pagination">
                <Pagination />
              </div>
            </div>
          </div>
        
      </div> */}
      
    </div>
    </div>
   </>
  
  );
}

type HitProps = {
  hit: Hit;
};

function Hit({ hit }: HitProps) {
  return (
    // <article>
       <div className="col-lg-12 col-md-12" key={hit.objectID}>
                          <div className="package-wrap">
                            <figure className="feature-image">
                              <Link to={`/tours/${hit.objectID}`}>
                                <img className="w-full" src={hit.main_img} alt="" />
                              </Link>
                            </figure>
                            <div className="package-price">
                              <h6>
                                {/* <span>VND {adult_price} </span> / mỗi người */}
                              </h6>
                            </div>
                            <div className="package-content-wrap">
                              {/* <div className="package-meta text-center"></div> */}
                              <div className="package-content">
                                <h3 className="margin-top-12">
                                  <Link className="mt-12" to={`/tours/${hit.objectID}`}>
                                  <Highlight attribute="name" hit={hit} />
                                  </Link>
                                </h3>
                                <div className="review-area">
                                  <span className="review-text">
                                    {/* ({view_count} reviews) */}
                                  </span>
                                  <div
                                    className="rating-start"
                                    title="Rated 5 out of 5"
                                  >
                                    <span className="w-3/5"></span>
                                  </div>
                                </div>
                                <p>
        <Highlight attribute="details" hit={hit} />
      </p>
                                <div className="btn-wrap">
                                  <a href="#" className="button-text width-6">
                                    Đặt ngay
                                    <i className="fas fa-arrow-right"></i>
                                  </a>
                                  <a href="#" className="button-text width-6">
                                    Thêm vào yêu thích
                                    <i className="far fa-heart"></i>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
     
      
    // </article>
  );
}
