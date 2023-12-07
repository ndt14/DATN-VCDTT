import { useGetPrivacyQuery } from "../../../api/privacy";
import { Privacy } from "../../../interfaces/Privacy";
import { Skeleton } from "antd";



const PrivacyPolicy = () => {
  const {data, isLoading} = useGetPrivacyQuery();
  console.log(data);
  const privacy = data?.data?.privacy;

 return(
  <>


  <div className="container">
    {/* <h3 className="text-center">Chính sách & Điều khoản </h3> */}
    {isLoading ? (
                <div>
                <Skeleton />
                <Skeleton />
                <Skeleton />
                <Skeleton />
                <Skeleton />
              </div>
 

              ) : (
   <div>
  {privacy?.map(({content}:Privacy)=>{
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
  })}


  </div>
              )}
              </div>
  </>
 )
};

export default PrivacyPolicy;
