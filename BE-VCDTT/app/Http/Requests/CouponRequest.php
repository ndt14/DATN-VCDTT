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
                            'code' => 'required',
                            'type' => 'required',
                            'price' => 'required',
                            'start_date' => 'required',
                            'expiration_date' => 'required',
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
                        $rule = [
                            'name' => 'required',
                            'code' => 'required',
                            'type' => 'required',
                            'price' => 'required',
                            'start_date' => 'required',
                            'expiration_date' => 'required',
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
            'start_date.required' => 'Ngày bắt đầu coupon không được trống',
            'expiration_date.required' => 'Ngày kết thúc coupon không được trống',
            'type.required' => 'Loại giảm giá không được trống',
            'price' => 'Giá giảm tương ứng không được trống'
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
