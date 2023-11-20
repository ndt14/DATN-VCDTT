import React from "react";
import { useGetPrivacyQuery } from "../../../api/privacy";
import { Privacy } from "../../../interfaces/privacy";
import { useGetBankNameQuery, useGetLogoQuery } from "../../../api/setting";

type Props = {};

const PrivacyPolicy = (props: Props) => {
  const {data} = useGetPrivacyQuery();
  console.log(data);
  const privacy = data?.data.privacy;
  const {data:logo} = useGetLogoQuery()
  console.log(logo);
  const {data:bankName} = useGetBankNameQuery()
  console.log(bankName);
 return(
  <>
  <div className="container">
    <h3 className="text-center">Chính sách & Điều khoản </h3>
{
  privacy?.map(({id,title,type,content,status}:Privacy)=>{
    return(
      <>
      <div>
        {/* <h1>{title}</h1> */}
        <span
                                      className="mt-2"
                                      dangerouslySetInnerHTML={{
                                        __html: content,
                                      }}
                                    ></span>
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
