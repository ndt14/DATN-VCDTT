import {FooterAdmin, HeaderAdmin, SideBarAdmin } from '../componenets'
import { Outlet } from 'react-router-dom'

type Props = {}

const LayoutAdmin = (props: Props) => {
  return (
   <>
    <div id="wrapper">
   <HeaderAdmin/>
   <Outlet/>
   <SideBarAdmin/>
   <FooterAdmin/>
</div>
   </>
  )
}

export default LayoutAdmin