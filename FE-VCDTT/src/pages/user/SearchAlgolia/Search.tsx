
import algoliasearch from "algoliasearch/lite";
import {
  Configure,
  HierarchicalMenu,
 
  Hits,
  InstantSearch,
  
  Pagination,
  
  // RefinementList,
  SortBy,
  SearchBox,
  useInstantSearch,
  
  
} from "react-instantsearch";

import { Panel } from "./Panel";

import type { Hit } from "instantsearch.js";

import "./Search.css";
import { Link, useLocation } from "react-router-dom";
import { NoResultsBoundary } from "./Noresults";
import { PriceSlider } from "./PriceSider";
import { AiFillEye } from "react-icons/ai";
import { Rate } from "antd";
import SecondaryBanner from "../../../componenets/User/SecondaryBanner";
import { Ratings } from "./Rating";


const searchClient = algoliasearch(
  "ZKNG517W50",
  "f2d72a41c3b3dd95d40c9d0ac7e56434"
);

export function Search() {
  const { search } = useLocation();
  console.log(search);

  // const queryParams = new URLSearchParams(search);
  // const queryParam = queryParams.get("?tours%5Bquery%5D");
  // const [query, setQuery] = useState(queryParam || "");

  // Lấy giá trị từ Local Storage
  const separatorText = localStorage.getItem("separatorText");
  const submitText = localStorage.getItem("submitText");

  const separator = document.querySelector(".ais-RangeInput-separator");
  if (separator) {
    // Thay đổi nội dung của thẻ và lưu giá trị mới vào Local Storage
    separator.textContent = separatorText || "Đến";
    localStorage.setItem("separatorText", separator.textContent);
  }

  const submit = document.querySelector(".ais-RangeInput-submit");
  if (submit) {
    // Thay đổi nội dung của thẻ và lưu giá trị mới vào Local Storage
    submit.textContent = submitText || "Tìm";
    localStorage.setItem("submitText", submit.textContent);
  }

  const titleElement = document.querySelector("title");
  if (titleElement) {
    titleElement.innerText = "Tìm kiếm tour";
  }

  const dataTitle = "Tìm kiếm tour";
  return (
    <>
      <div>
      <SecondaryBanner>{dataTitle}</SecondaryBanner>
        <div className="container">
          <div className="row">
            <InstantSearch
              searchClient={searchClient}
              indexName="tours"
              routing={true}
              insights={true}
            >
              <Configure hitsPerPage={4} />
              <div className="col-lg-3">
                <br />
                 <Panel header="Bộ loc tìm kiếm">
                 
                </Panel>
             
                <Panel header="Các vùng miền">
                  <HierarchicalMenu
                    attributes={[
                      "category.lvl0",
                      "category.lvl1",
                      // 'hierarchicalCategories.lvl2',
                    ]}
                    showMore={true}
                  />
                </Panel>

                <Panel header="Đánh giá">
                  <Ratings attribute="rating" />
                </Panel>
                <Panel header="Khoảng giá">
                  <br />
                <PriceSlider attribute="adult_price"/>
                  {/* <RangeInput attribute="adult_price" precision={1} /> */}
                </Panel>
              </div>
              <div className="col-lg-9">
                <div className="row my-4">
                  <div className="col-lg-8 height">
                    <SearchBox
                      placeholder="Tìm kiếm"
                      className="searchbox"
                      searchAsYouType={false}
                    />
                  </div>
                  <div className="col-lg-4">
                    <SortBy
                      items={[
                        { label: "Mặc định", value: "tours" },
                        {
                          label: "Giá từ cao đến thấp",
                          value: "tours_price_asc",
                        },
                        {
                          label: "Giá thấp đến cao",
                          value: "tours_price_desc",
                        },
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

                <NoResultsBoundary fallback={<NoResults />} children={undefined} />
                {/* <div className='row'> */}
                <Hits
                  hitComponent={Hit}
                  classNames={{
                    list: "d-flex flex-row flex-wrap",
                    item: "col-lg-6 p-2 w-full",
                  }}
                />
                {/* </div> */}

                <div className="pagination">
                <Pagination padding={2} showFirst={false} showLast={false} />
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
    <>
     <div className="hits-empty-state">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        xmlnsXlink="http://www.w3.org/1999/xlink"
        width="138"
        height="138"
        className="hits-empty-state-image"
      >
        <defs>
          <linearGradient id="c" x1="50%" x2="50%" y1="100%" y2="0%">
            <stop offset="0%" stopColor="#F5F5FA" />
            <stop offset="100%" stopColor="#FFF" />
          </linearGradient>
          <path
            id="b"
            d="M68.71 114.25a45.54 45.54 0 1 1 0-91.08 45.54 45.54 0 0 1 0 91.08z"
          />
          <filter
            id="a"
            width="140.6%"
            height="140.6%"
            x="-20.3%"
            y="-15.9%"
            filterUnits="objectBoundingBox"
          >
            <feOffset dy="4" in="SourceAlpha" result="shadowOffsetOuter1" />
            <feGaussianBlur
              in="shadowOffsetOuter1"
              result="shadowBlurOuter1"
              stdDeviation="5.5"
            />
            <feColorMatrix
              in="shadowBlurOuter1"
              result="shadowMatrixOuter1"
              values="0 0 0 0 0.145098039 0 0 0 0 0.17254902 0 0 0 0 0.380392157 0 0 0 0.15 0"
            />
            <feOffset dy="2" in="SourceAlpha" result="shadowOffsetOuter2" />
            <feGaussianBlur
              in="shadowOffsetOuter2"
              result="shadowBlurOuter2"
              stdDeviation="1.5"
            />
            <feColorMatrix
              in="shadowBlurOuter2"
              result="shadowMatrixOuter2"
              values="0 0 0 0 0.364705882 0 0 0 0 0.392156863 0 0 0 0 0.580392157 0 0 0 0.2 0"
            />
            <feMerge>
              <feMergeNode in="shadowMatrixOuter1" />
              <feMergeNode in="shadowMatrixOuter2" />
            </feMerge>
          </filter>
        </defs>
        <g fill="none" fillRule="evenodd">
          <circle
            cx="68.85"
            cy="68.85"
            r="68.85"
            fill="#5468FF"
            opacity=".07"
          />
          <circle
            cx="68.85"
            cy="68.85"
            r="52.95"
            fill="#5468FF"
            opacity=".08"
          />
          <use fill="#000" filter="url(#a)" xlinkHref="#b" />
          <use fill="url(#c)" xlinkHref="#b" />
          <path
            d="M76.01 75.44c5-5 5.03-13.06.07-18.01a12.73 12.73 0 0 0-18 .07c-5 4.99-5.03 13.05-.07 18a12.73 12.73 0 0 0 18-.06zm2.5 2.5a16.28 16.28 0 0 1-23.02.09A16.29 16.29 0 0 1 55.57 55a16.28 16.28 0 0 1 23.03-.1 16.28 16.28 0 0 1-.08 23.04zm1.08-1.08l-2.15 2.16 8.6 8.6 2.16-2.15-8.6-8.6z"
            fill="#5369FF"
          />
        </g>
      </svg>

      <p className="hits-empty-state-title">
      Không tìm thấy kết quả cho từ khóa <q>{indexUiState.query}</q> vui lòng nhập lại.
      </p>
     
      {/* <p className="hits-empty-state-description">{description}</p> */}

  
    </div>
    </>
    // <div>
    //   <p>
    //     Không tìm thấy kết quả cho từ khóa <q>{indexUiState.query}</q> vui lòng
    //     điền lại.
    //   </p>
    // </div>
  );
}

type HitProps = {
  hit: Hit;
};

function Hit({ hit }: HitProps) {
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
    // <article>
    <div className="" key={hit.objectID}>
      {hit.sale_percentage > 0 ? (
                                <div className="bg-primary text-white position-absolute discount badge ">
                                  <span
                                    className="fs-4 font-weight-bold font-italic d-flex align-items-center justify-content-center"
                                    style={{ height: "100%" }}
                                  >
                                    -{hit.sale_percentage}%
                                  </span>
                                </div>
                              ) : (
                                <span></span>
                              )}
    <div className="package-wrap">
      <figure className="feature-image">
        <Link to={`/tours/${hit.objectID}-${createSlugFromString( hit.name )}.html`}>
          <img
            className="w-full img-fixed"
            src={hit.main_img}
            alt=""
          />
        </Link>
      </figure>
      <div className="package-price">
        <h6 className="">
        <span>
                                      {new Intl.NumberFormat("vi-VN", {
                                        style: "currency",
                                        currency: "VND",
                                      }).format(
                                        (hit.adult_price *
                                          (100 - hit.sale_percentage)) /
                                          100
                                      )}{" "}
                                    </span>{" "}
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
            <div
              className=""
              title={`Rated ${hit.rating} out of 5`}
            >
              <span className="w-90">
                <Rate allowHalf disabled value={hit.rating} />
              </span>{" "}
              <span className="review-text">
                ({hit.view_count} <AiFillEye size={25} />)
              </span>
            </div>
          </div>
          <div className="text-description">
            <span
              className=""
              dangerouslySetInnerHTML={{
                __html: hit.details,
              }}
            ></span>
          </div>

        
        </div>
      </div>
    </div>
  </div>

    // </article>
  );
}
