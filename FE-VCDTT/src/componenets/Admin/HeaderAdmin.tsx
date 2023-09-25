import React from 'react'

type Props = {}

const HeaderAdmin = (props: Props) => {
  return (
    <>
    <div className="navbar-custom">
            <ul className="list-unstyled topnav-menu float-end mb-0">

                <li className="d-none d-lg-block">
                    <form className="app-search">
                        <div className="app-search-box">
                            <div className="input-group">
                                <input type="text" className="form-control" placeholder="Search..." id="top-search"/>
                                <button className="btn input-group-text" type="submit">
                                    <i className="fe-search"></i>
                                </button>
                            </div>
                            <div className="dropdown-menu dropdown-lg" id="search-dropdown">
                                {/* <!-- item--> */}
                                <div className="dropdown-header noti-title">
                                    <h5 className="text-overflow mb-2">Found 22 results</h5>
                                </div>
    
                                {/* <!-- item--> */}
                                <a href="javascript:void(0);" className="dropdown-item notify-item">
                                    <i className="fe-home me-1"></i>
                                    <span>Analytics Report</span>
                                </a>
    
                                {/* <!-- item--> */}
                                <a href="javascript:void(0);" className="dropdown-item notify-item">
                                    <i className="fe-aperture me-1"></i>
                                    <span>How can I help you?</span>
                                </a>
                    
                                {/* <!-- item--> */}
                                <a href="javascript:void(0);" className="dropdown-item notify-item">
                                    <i className="fe-settings me-1"></i>
                                    <span>User profile settings</span>
                                </a>

                                {/* <!-- item--> */}
                                <div className="dropdown-header noti-title">
                                    <h6 className="text-overflow mb-2 text-uppercase">Users</h6>
                                </div>

                                <div className="notification-list">
                                    {/* <!-- item--> */}
                                    <a href="javascript:void(0);" className="dropdown-item notify-item">
                                        <div className="d-flex align-items-start">
                                            <img className="d-flex me-2 rounded-circle" src="assets/images/users/user-2.jpg" alt="Generic placeholder image" height="32"/>
                                            <div className="w-100">
                                                <h5 className="m-0 font-14">Erwin E. Brown</h5>
                                                <span className="font-12 mb-0">UI Designer</span>
                                            </div>
                                        </div>
                                    </a>

                                    {/* <!-- item--> */}
                                    <a href="javascript:void(0);" className="dropdown-item notify-item">
                                        <div className="d-flex align-items-start">
                                            <img className="d-flex me-2 rounded-circle" src="assets/images/users/user-5.jpg" alt="Generic placeholder image" height="32"/>
                                            <div className="w-100">
                                                <h5 className="m-0 font-14">Jacob Deo</h5>
                                                <span className="font-12 mb-0">Developer</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
    
                            </div> 
                        </div>
                    </form>
                </li>

                <li className="dropdown d-inline-block d-lg-none">
                    <a className="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i className="fe-search noti-icon"></i>
                    </a>
                    <div className="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                        <form className="p-3">
                            <input type="text" className="form-control" placeholder="Search ..." aria-label="Recipient's username"/>
                        </form>
                    </div>
                </li>
    
                <li className="dropdown notification-list topbar-dropdown">
                    <a className="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i className="fe-bell noti-icon"></i>
                        <span className="badge bg-danger rounded-circle noti-icon-badge">9</span>
                    </a>
                    <div className="dropdown-menu dropdown-menu-end dropdown-lg">

                        {/* <!-- item--> */}
                        <div className="dropdown-item noti-title">
                            <h5 className="m-0">
                                <span className="float-end">
                                    <a href="" className="text-dark">
                                        <small>Clear All</small>
                                    </a>
                                </span>Notification
                            </h5>
                        </div>

                        <div className="noti-scroll" data-simplebar>

                            {/* <!-- item--> */}
                            <a href="javascript:void(0);" className="dropdown-item notify-item active">
                                <div className="notify-icon">
                                    <img src="assets/images/users/user-1.jpg" className="img-fluid rounded-circle" alt="" /> </div>
                                <p className="notify-details">Cristina Pride</p>
                                <p className="text-muted mb-0 user-msg">
                                    <small>Hi, How are you? What about our next meeting</small>
                                </p>
                            </a>

                            {/* <!-- item--> */}
                            <a href="javascript:void(0);" className="dropdown-item notify-item">
                                <div className="notify-icon bg-primary">
                                    <i className="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p className="notify-details">Caleb Flakelar commented on Admin
                                    <small className="text-muted">1 min ago</small>
                                </p>
                            </a>

                            {/* <!-- item--> */}
                            <a href="javascript:void(0);" className="dropdown-item notify-item">
                                <div className="notify-icon">
                                    <img src="assets/images/users/user-4.jpg" className="img-fluid rounded-circle" alt="" /> </div>
                                <p className="notify-details">Karen Robinson</p>
                                <p className="text-muted mb-0 user-msg">
                                    <small>Wow ! this admin looks good and awesome design</small>
                                </p>
                            </a>

                            {/* <!-- item--> */}
                            <a href="javascript:void(0);" className="dropdown-item notify-item">
                                <div className="notify-icon bg-warning">
                                    <i className="mdi mdi-account-plus"></i>
                                </div>
                                <p className="notify-details">New user registered.
                                    <small className="text-muted">5 hours ago</small>
                                </p>
                            </a>

                            {/* <!-- item--> */}
                            <a href="javascript:void(0);" className="dropdown-item notify-item">
                                <div className="notify-icon bg-info">
                                    <i className="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p className="notify-details">Caleb Flakelar commented on Admin
                                    <small className="text-muted">4 days ago</small>
                                </p>
                            </a> cd

                            {/* <!-- item--> */}
                            <a href="javascript:void(0);" className="dropdown-item notify-item">
                                <div className="notify-icon bg-secondary">
                                    <i className="mdi mdi-heart"></i>
                                </div>
                                <p className="notify-details">Carlos Crouch liked
                                    <b>Admin</b>
                                    <small className="text-muted">13 days ago</small>
                                </p>
                            </a>
                        </div>

                        {/* <!-- All--> */}
                        <a href="javascript:void(0);" className="dropdown-item text-center text-primary notify-item notify-all">
                            View all
                            <i className="fe-arrow-right"></i>
                        </a>

                    </div>
                </li>

                <li className="dropdown notification-list topbar-dropdown">
                    <a className="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="assets/images/users/user-1.jpg" alt="user-image" className="rounded-circle"/>
                        
                        <span className="pro-user-name ms-1">
                            Nowak <i className="mdi mdi-chevron-down"></i> 
                        </span>
                    </a>
                    <div className="dropdown-menu dropdown-menu-end profile-dropdown ">
                        {/* <!-- item--> */}
                        <div className="dropdown-header noti-title">
                            <h6 className="text-overflow m-0">Welcome !</h6>
                        </div>

                        {/* <!-- item--> */}
                        <a href="contacts-profile.html" className="dropdown-item notify-item">
                            <i className="fe-user"></i>
                            <span>My Account</span>
                        </a>

                        {/* <!-- item--> */}
                        <a href="auth-lock-screen.html" className="dropdown-item notify-item">
                            <i className="fe-lock"></i>
                            <span>Lock Screen</span>
                        </a>

                        <div className="dropdown-divider"></div>

                        {/* <!-- item--> */}
                        <a href="auth-logout.html" className="dropdown-item notify-item">
                            <i className="fe-log-out"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>

                <li className="dropdown notification-list">
                    <a href="javascript:void(0);" className="nav-link right-bar-toggle waves-effect waves-light">
                        <i className="fe-settings noti-icon"></i>
                    </a>
                </li>

            </ul>

            {/* <!-- LOGO --> */}
            <div className="logo-box">
                <a href="index.html" className="logo logo-light text-center">
                    <span className="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22"/>
                    </span>
                    <span className="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="16"/>
                    </span>
                </a>
                <a href="index.html" className="logo logo-dark text-center">
                    <span className="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22"/>
                    </span>
                    <span className="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="16"/>
                    </span>
                </a>
            </div>

            <ul className="list-unstyled topnav-menu topnav-menu-left mb-0">
                <li>
                    <button className="button-menu-mobile disable-btn waves-effect">
                        <i className="fe-menu"></i>
                    </button>
                </li>

                <li>
                    <h4 className="page-title-main">Dashboard</h4>
                </li>
    
            </ul>

            <div className="clearfix"></div> 
       
    </div>
    </>
  )
}

export default HeaderAdmin