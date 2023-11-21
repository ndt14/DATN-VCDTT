import { Link } from "react-router-dom";
import "./TourPreview.css";

const TourPreview = () => {
  return (
    <div className="col-lg-4 col-md-6">
      <div className="package-wrap">
        <figure className="feature-image">
          <Link to="tours/1">
            <img
              className="w-full"
              src="../../../../assets/images/img5.jpg"
              alt=""
            />
          </Link>
        </figure>
        <div className="package-price">
          <h6>
            <span>VND 2,900,000 </span> / mỗi người
          </h6>
        </div>
        <div className="package-content-wrap">
          {/* <div className="package-meta text-center"></div> */}
          <div className="package-content">
            <h3 className="margin-top-12">
              <Link className="mt-12" to="tours/1">
                Sunset view of beautiful lakeside resident
              </Link>
            </h3>
            <div className="review-area">
              <span className="review-text">(25 reviews)</span>
              <div className="rating-start" title="Rated 5 out of 5">
                <span className="w-3/5"></span>
              </div>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit luctus nec
              ullam. Ut elit tellus, luctus nec ullam elit tellpus.
            </p>
            <div className="btn-wrap">
              <a href="#" className="button-text width-6">
                Đặt ngay<i className="fas fa-arrow-right"></i>
              </a>
              <a href="#" className="button-text width-6">
                Thêm vào yêu thích<i className="far fa-heart"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default TourPreview;
