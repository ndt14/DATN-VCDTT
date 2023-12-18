<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseHistoryRequest extends FormRequest
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
                    case 'purchaseHistoryManagementEdit':
                        $rule = [
                            "email" => "required|email",
                            "phone_number" => "required",
                            "tour_name" => "required",
                            "tour_duration" => "required",
                            "tour_start_time" => "required",
                        ];
                        break;
                endswitch;
                break;
        endswitch;
        return $rule;
    }

    public function messages(): array
    {
        return [
            "email.required" => "Email người đặt không được để trống",
            "email.email" => "Địa chỉ email sai định dạng",
            "phone_number.required" => "Số điện thoại người đặt không được để trống",
            "tour_name" => "Tên tour không được để trống",
            "tour_duration.required" => "Độ dài tour không được để trống",
            "tour_start_time.required" => "Thời gian bắt đầu không để trống",
        ];
    }
}
