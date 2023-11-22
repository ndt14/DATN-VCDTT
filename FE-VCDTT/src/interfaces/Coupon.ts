export interface Coupon {
    user_id: number,
    coupon_code: string,
    id?:string,
    name:string,
    code: string,
    created_at:string,
    start_date:number,
    expiration_date:number,
    percentage_price: number,

}