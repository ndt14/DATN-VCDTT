import React from "react";
import { useGetPrivacyQuery } from "../../../api/privacy";
import { Privacy } from "../../../interfaces/privacy";

type Props = {};

const PrivacyPolicy = (props: Props) => {
  const {data} = useGetPrivacyQuery();
  console.log(data);
  const privacy = data?.data.privacy;
 return(
  <>
  <div className="container">
    <h1>Chính sách & Điều khoản </h1>
{
  privacy?.map(({id,title,type,content,status}:Privacy)=>{
    return(
      <>
      <div>
        <h1>{title}</h1>
        <p>{content}</p>
      </div>
      </>
    )
  })
}
  </div>
  </>
 )
};

export default PrivacyPolicy;
