import React from "react";
import "./UserProfile.css";
import { Tabs } from "antd";

const userData = JSON.parse(localStorage.getItem("user"));
const userName = userData?.name;
const userId = userData?.id;
const userEmail = userData?.email;
const phoneNumber = userData?.phone_number;
const userAddress = userData?.address;

const { TabPane } = Tabs;

const UserProfile = () => {
  return (
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
      <section className="container" style={{ marginBottom: "200px" }}>
        <div className="row">
          <div className="col-4">
            <div className="border">
              <div className="d-flex p-3">
                <div>
                  <img
                    style={{ width: "70px" }}
                    src="../../../../assets/images/travel.png"
                    alt=""
                  />
                </div>
                <div>
                  <h3>Vũ Hồng Thái</h3>
                  <p>hongthai96961996@gmail.com</p>
                </div>
              </div>
              <hr />
              {/* Left panel */}
              <nav>
                <ul className="nav row" id="myTab" role="tablist">
                  <li className="nav-item" role="presentation">
                    <button
                      className="nav-link border-0 btn w-100"
                      data-bs-toggle="tab"
                      data-bs-target="#user-info"
                      type="button"
                      role="tab"
                      aria-controls="profile"
                      aria-selected="false"
                    >
                      Chỉnh sửa
                    </button>
                  </li>
                  <li className="nav-item" role="presentation">
                    <button
                      className="nav-link border-0 btn w-100"
                      id="-tab"
                      data-bs-toggle="tab"
                      data-bs-target="#tour-ordered"
                      type="button"
                      role="tab"
                      aria-controls="contact"
                      aria-selected="false"
                    >
                      Tour đã đặt
                    </button>
                  </li>

                  <li className="nav-item" role="presentation">
                    <button
                      className="nav-link border-0 btn w-100"
                      data-bs-toggle="tab"
                      data-bs-target="#tour-favorite"
                      type="button"
                      role="tab"
                      aria-controls="profile"
                      aria-selected="false"
                    >
                      Tour yêu thích
                    </button>
                  </li>
                </ul>
              </nav>
              {/* End left panel */}
            </div>
          </div>
          <div className="col-8">
            {/*  */}
            <Tabs
              defaultActiveKey="1"
              style={{ display: "flex", justifyContent: "space-between" }}
            >
              <TabPane tab="Thông tin của tôi" key="1" style={{ width: "50%" }}>
                <h4>Thông tin</h4>
                <p>Tên tài khoản: {userName} </p>
                <p>Email: {userEmail}</p>
                <p>Điện thoại: {phoneNumber}</p>
                <p>Địa chỉ: {userAddress}</p>
              </TabPane>
              <TabPane tab="Chỉnh sửa thông tin" key="2">
                Content of Tab Pane 2
              </TabPane>
            </Tabs>
          </div>
        </div>
      </section>
    </div>
  );
};

export default UserProfile;
