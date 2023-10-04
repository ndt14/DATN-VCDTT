<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
class CouponRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'tour_id' => 'required',
            'cate_id' => 'required',
            'percentage_price' => 'required',
            'fixed_price' => 'required',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên coupon không được trống',
            'description.required' => 'Mô tả coupon không được trống',
            'start_date.required' => 'Ngày bắt đầu coupon không được trống',
            'end_date.required' => 'Ngày kết thúc coupon không được trống',
            'tour_id.required' => 'Tour áp dụng coupon không được trống',
            'cate_id.required' => 'Danh mục áp dụng coupon không được trống',
            'percentage_price.required' => 'Phần trăm giảm giá không được trống',
            'fixed_price.required' => 'Giá giảm cố định không được trống',
            'status.required' => 'Trạng thái của coupon không được trống'  
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'errors' => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw (new ValidationException($validator, $response));
    }
}
