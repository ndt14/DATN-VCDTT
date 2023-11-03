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
  SearchBox,
} from 'react-instantsearch';

import { Panel } from './Panel';

import type { Hit } from 'instantsearch.js';

import './Search.css';
import { Link, useLocation } from 'react-router-dom';


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
          <Configure hitsPerPage={8} />
              <div className="col-lg-4">
              <Panel header="brand">
                <RefinementList attribute="parent_category" showMore={true} limit={5}/>
              </Panel>
            
            <Panel header="Price">
              <RangeInput attribute="adult_price" precision={1} />
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
                </div>
                <div className="col-lg-8">
                <SearchBox  placeholder="Tìm kiếm" className="searchbox" searchAsYouType={false} />
              <Hits hitComponent={Hit} />

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
