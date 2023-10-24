import React from "react";
import "./UserProfile.css";
import { Tabs } from "antd";
import { useState, useEffect } from "react";
import { useUpdateUserMutation, useGetUserByIdQuery } from "../../../api/user";
import { User } from "../../../interfaces/User";
import { Link } from "react-router-dom";
import { log } from "console";

const UserProfile = () => {
  const user = JSON.parse(localStorage.getItem("user"));
  const userId = user?.id;
  const { data: userData } = useGetUserByIdQuery(userId || "");

  const userName = userData?.data?.user.name;

  const userEmail = userData?.data?.user.email;
  const phoneNumber = userData?.data?.user.phone_number;
  const userAddress = userData?.data?.user.address;

  const { TabPane } = Tabs;
  const [editUser] = useUpdateUserMutation();

  const [formValues, setFormValues] = useState({
    id: userId ? userId : "",
    name: userName,
    email: userEmail,
    address: userAddress,
    phone_number: phoneNumber,
  });
  useEffect(() => {
    if (userData) {
      const { name, email, phone_number, address } = userData.data.user;
      setFormValues({
        ...formValues,
        name: name || "",
        email: email || "",
        address: address || "",
        phone_number: phone_number || "",
      });
    }
  }, [userData]);
  const handleInputChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setFormValues((prevValues) => ({
      ...prevValues,
      [name]: value,
    }));
  };
  const handleUpdate = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    console.log(formValues);
    editUser(formValues)
      .then((response) => {
        alert(response?.data?.message);
      })
      .catch((error) => {
        // Handle any errors here
        console.error(error);
      });
  };
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
                  <h3>{userName} </h3>
                  <p>{userEmail}</p>
                </div>
              </div>
              <hr />
              {/* Left panel */}

              <Link
                to={"/user/profile"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className=" border-0 btn w-100" type="button">
                  Hồ sơ
                </button>
              </Link>

              <Link
                to={"/user/tours"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className="border-0 btn w-100" type="button">
                  Tour đã đặt
                </button>
              </Link>

              <Link
                to={"/user/profile"}
                className="nav row "
                id="myTab"
                role="tablist"
              >
                <button className=" border-0 btn w-100" type="button">
                  Tour yêu thích
                </button>
              </Link>

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
                <p>Họ và tên: {userName}</p>
                <p>Email: {userEmail}</p>
              </TabPane>
              <TabPane tab="Chỉnh sửa thông tin" key="2">
                <form onSubmit={handleUpdate}>
                  <div className="col-sm-6">
                    <div className="form-group">
                      <label className="d-inline-flex">
                        Họ tên <div className=" ml-1 text-danger">*</div>
                      </label>
                      <input
                        type="text"
                        name="name"
                        className=""
                        value={formValues.name}
                        onChange={handleInputChange}
                      />
                    </div>
                  </div>
                  <div className="col-sm-6">
                    <div className="form-group">
                      <label className="d-inline-flex">
                        Email <div className=" ml-1 text-danger">*</div>
                      </label>
                      <input
                        type="text"
                        name="email"
                        className=""
                        value={formValues.email}
                        onChange={handleInputChange}
                      />
                    </div>
                  </div>
                  <div className="col-sm-6">
                    <div className="form-group">
                      <label className="d-inline-flex">
                        Số điện thoại <div className=" ml-1 text-danger">*</div>
                      </label>
                      <input
                        type="text"
                        name="phone_number"
                        className=""
                        value={formValues.phone_number}
                        onChange={handleInputChange}
                      />
                    </div>
                  </div>
                  <button type="submit">Submit</button>
                </form>
              </TabPane>
            </Tabs>
          </div>
        </div>
      </section>
    </div>
  );
};

export default UserProfile;
