
import { useParams } from "react-router-dom";
import { useGetBillByIdQuery } from "../../../api/bill";
import { Skeleton } from "antd";

// type Props = {}

const UserPolicy = () => {
  const { id } = useParams<{ id: string }>();
  const { data: userData, isLoading } = useGetBillByIdQuery(id || "");
  const term = userData?.data.purchase_history.payment_term;
  const privacy = userData?.data.purchase_history.payment_privacy;

  return (
    <section className="container" style={{ marginTop: "150px" }}>
      <h2>ĐIỀU KHOẢN</h2>

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
          <span
            className=""
            dangerouslySetInnerHTML={{
              __html: term,
            }}
          ></span>

          <span
            className=""
            dangerouslySetInnerHTML={{
              __html: privacy,
            }}
          ></span>
        </div>
      )}
    </section>
  );
};

export default UserPolicy;
