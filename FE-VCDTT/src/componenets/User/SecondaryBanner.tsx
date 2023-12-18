
import { useGetSubBannerQuery } from '../../api/setting';
import { Setting } from '../../interfaces/Setting';



const SecondaryBanner = ( {children}:any) => {
    const { data: dataBanner } = useGetSubBannerQuery();
    let backgroundImageUrl = ''; // Define the variable outside the map function

    if (dataBanner?.data.keyvalue) {
        backgroundImageUrl = dataBanner.data.keyvalue.map(({ value }: Setting) => {
            return value;
        })[0]; // Assuming you want the first value, adjust as needed
    }

    const containerStyle = {
        background: `url(${backgroundImageUrl})`,
        backgroundSize: 'cover',
    };

    return (
        <section className="inner-banner-wrap">
            <div className="inner-baner-container" style={containerStyle}>
                <div className="container">
                    <div className="inner-banner-content">
                        <h2 className="inner-title">{children}</h2>
                    </div>
                </div>
            </div>
            <div className="inner-shape"></div>
        </section>
    );
};

export default SecondaryBanner;
