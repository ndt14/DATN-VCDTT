export interface Bill {
    id:number;
    user_id?: number;
    name?: string;
    email?:string;
    phone_number?:string;
    tour_name?:string;
    tour_duration?:number;
    tour_child_price?:number;
    child_count?:number
    tour_adult_price?:number;
    adult_count?:number;
    tour_sale_percentage? :number;
    tour_start_destination? :string
    tour_end_destination? : string
    tour_location? : string
    coupon_info? : string
    coupon_percentage? :number;
    refund_percentage? :number;
    coupon_fixed? :number;
    tour_start_time? :number;
    tour_end_time? :number;
    transaction_id?: number;
    payment_status?:number
}
