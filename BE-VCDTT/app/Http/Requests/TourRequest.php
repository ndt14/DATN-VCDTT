<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required',
            'duration' => 'required',
            'child_price' => 'required',
            'adult_price' => 'required',
            'sale_percentage' => 'required',
            'start_destination' => 'required',
            'end_destination' => 'required',
            'tourist_count' => 'required',
            'details' => 'required',
            'location' => 'required',
            'exact_location' => 'required',
            'main_img' => 'required',
            'status' => 'required',
            'view_count' => 'required',
        ];
    }

    public function messages()
    {
        return
            [
                'name.required' => 'Tên của tour không được để trống',
                'duration.required' => 'Khoảng thời gian tour không được để trống',
                'child_price.required' => 'Giá tour cho trẻ nhỏ không được trống',
                'adult_price.required' => 'Giá tour cho người lớn không được trống',
                'sale_percentage.required' => 'Phần trăm giảm giá không được trống',
                'start_destination.required' => 'Điểm bắt đầu không được để trống',
                'end_destination.required' => 'Điểm kết thúc không được để trống',
                'tourist_count.required' => 'Số lượng khách du lịch không được để trống',
                'details.required' => 'Chi tiết tour không được để trống',
                'location.required' => 'Vị trí tour du lịch không được để trống',
                'exact_location.required' => 'Ví trí chính xác tour du lịch không được để trống',
                'main_img.required' => 'Ảnh chính của tour không được để trống',
                'status.required' => 'Trạng thái tour không được để trống',
                'view_count.required' => 'Số lượt xem không được để trống',

            ];
    }
}
