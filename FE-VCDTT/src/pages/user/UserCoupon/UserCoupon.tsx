import {
 
  useGetUserByIdQuery,
 
} from "../../../api/user";

import { Link } from "react-router-dom";
import { Skeleton, Table } from "antd";
import { IoPersonOutline } from "react-icons/io5";
import { FaRegHeart } from "react-icons/fa";
import { FaRegListAlt } from "react-icons/fa";
import { useGetCouponByUserQuery } from "../../../api/coupon";
import { Coupon } from "../../../interfaces/Coupon";
import SecondaryBanner from "../../../componenets/User/SecondaryBanner";


const UserCoupon = () => {
  const user = JSON.parse(localStorage.getItem("user")||"{}");
  const userId = user?.id;
  const { data: userData, isLoading } = useGetUserByIdQuery(userId || "");
  const {data: couponData} = useGetCouponByUserQuery(userId || "");
  console.log(couponData);
  
  const dataSource = couponData?.data?.coupons.map(({ id, name, code ,start_date, expiration_date,percentage_price}: Coupon) => {
    return {
        key: id,
        name,
        code,
        start_date,
        expiration_date,
        percentage_price
    };
});
const columns = [
  {
      title: "Mô tả mã giảm giá",
      dataIndex: "name",
      key: "name",
  },
  {
      title: "Tên mã giảm giá",
      dataIndex: "code",
      key: "code",
  },
  {
    title: "Phần trăm giảm giá",
    dataIndex: "percentage_price",
    key: "percentage_price",
},
  {
      title: "Ngày được dùng",
      dataIndex: "start_date",
      key: "start_date",
  },
  {
      title: "Ngày hết hạn",
      dataIndex: "expiration_date",
      key: "expiration_date",
  },
 
 
];
  // const userName = userData?.data?.user.name;
  // const userDateOfBirth = userData?.data?.user.date_of_birth;
  // const userEmail = userData?.data?.user.email;
  // const phoneNumber = userData?.data?.user.phone_number;
  // const userAddress = userData?.data?.user.address;
  // const userGender = userData?.data?.user.gender;
  const {
    name: userName,
    email: userEmail,
  } = userData?.data?.user ?? {};

  const dataTitle = "Mã giảm giá"

  return (
    <>
    <div>
    <SecondaryBanner>{dataTitle}</SecondaryBanner>
     
      <section className="container" style={{ marginBottom: "200px" }}>
        <div className="row">
          <div className="col-4">
            <div className="border">
              {isLoading ? (
                <Skeleton active />
              ) : (
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
              )}
              {/* <div className="d-flex p-3">
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
              </div> */}
              <hr />
              {/* Left panel */}
              {isLoading ? (
                <Skeleton active />
              ) : (
                <nav className="nav flex-column">
                  <Link
                    className="nav-link"
                    to={"/user/profile"}
                  >
                   <IoPersonOutline /> Thông tin cá nhân
                  </Link>
                  <Link className="nav-link active" to={"/user/tours"}>
                  <FaRegListAlt />  Tour đã đặt
                  </Link>
                  <Link className="nav-link" to={"/user/favorite"}>
                  <FaRegHeart />  Tour yêu thích
                  </Link>
                  <Link   className="nav-link text-white"
                    style={{ backgroundColor: "#1677FF" }} to={"/user/coupon"}>
                  <FaRegListAlt />  Mã Giảm giá
                  </Link>
                </nav>
              )}

              {/* End left panel */}
            </div>
          </div>

          <div className="col-8">
          <h2 className="font-bold text-2xl">Quản lý mã giảm giá</h2>
          <Table dataSource={dataSource} columns={columns} />
          </div>
        </div>
      </section>
    </div>
    </>
  )
}

export default UserCoupon