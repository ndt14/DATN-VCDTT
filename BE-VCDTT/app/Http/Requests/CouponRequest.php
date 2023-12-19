<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
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
        $rule = [];
        $currentAction = $this->route()->getActionMethod();

        switch ($this->method()):
            case 'POST':
                switch ($currentAction):
                    case 'couponManagementAdd':
                        $rule = [
                            'name' => 'required',
                            'code' => 'required|unique:coupons',
                            'type' => 'required',
                            'price' => 'required',
                            'start_date' => 'required',
                            'expiration_date' => 'required|date|after:start_date',
                            // 'percentage_price' => 'required',
                            // 'fixed_price' => 'required',
                            // 'tour_id' => ['nullable', Rule::requiredIf(function () {
                            //     return empty($this->input('cate_id'));
                            // })],
                            // 'cate_id' => ['nullable', Rule::requiredIf(function () {
                            //     return empty($this->input('tour_id'));
                            // })],
                        ];
                        break;

                    case 'couponManagementEdit':
                        $couponId = $this->route('id');
                        $rule = [
                            'name' => 'required',
                            'code' => [
                                'required',
                                Rule::unique('coupons')->ignore($couponId, 'id'),
                            ],
                            'type' => 'required',
                            'price' => 'required',
                            'start_date' => 'required',
                            'expiration_date' => 'required|date|after:start_date',
                            // 'percentage_price' => 'required',
                            // 'fixed_price' => 'required',
                            // 'tour_id' => ['nullable', Rule::requiredIf(function () {
                            //     return empty($this->input('cate_id'));
                            // })],
                            // 'cate_id' => ['nullable', Rule::requiredIf(function () {
                            //     return empty($this->input('tour_id'));
                            // })],
                        ];
                        break;
                endswitch;
                break;
        endswitch;
        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên coupon không được trống',
            'code.required' => 'Mã giảm giá không được trống',
            'code.unique' => 'Mã này đã tồn tại',
            'start_date.required' => 'Ngày bắt đầu coupon không được trống',
            'expiration_date.required' => 'Ngày kết thúc coupon không được trống',
            'type.required' => 'Loại giảm giá không được trống',
            'price' => 'Giá giảm tương ứng không được trống',
            'start_date.after' => 'Ngày hoạt động phải từ hôm nay chở đi',
            'expiration_date.after' => 'Ngày hết hạn phải sau ngày hoạt động ít nhất 1 ngày.',
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     $response = new Response([
    //         'errors' => $validator->errors()
    //     ], Response::HTTP_UNPROCESSABLE_ENTITY);
    //     throw (new ValidationException($validator, $response));
    // }
}
