export interface Bill {
    id?:number;
    user_id?: number;
    tour_id?:number;
    name?: string;
    email?:string;
    phone_number?:string;
    tour_name?:string;
    tour_duration?:number;
    tour_child_price?:number;
    child_count?:number
    tour_adult_price?:number;
    adult_count?:number;
    tour_sale_percentage?:number;
    tour_start_destination? :string
    tour_end_destination? : string
    tour_location? : string
    coupon_info? : string
    coupon_name?:string
    coupon_percentage? :number|null
    refund_percentage? :number;
    coupon_fixed? :number|null
    tour_start_time? :string;
    tour_end_time? :number;
    transaction_id?: number;
    payment_status?:number;
    purchase_status?:number;
    purchase_method?:number;
    tour_status?:number;
    tour_image?:string;
    comfirm_click?:number;
    data:any
}
