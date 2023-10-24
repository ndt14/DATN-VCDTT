<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    case 'userManagementAdd':
                        $rule = [
                            'name' => 'required',
                            'email' => 'required',
                            'password' => 'required',
                            'phone_number' => 'required',
                            'date_of_birth' => 'required',
                            'address' => 'required',
                            'gender' => 'required',
                            'image' => 'required',
                            'status' => 'required'
                        ];
                        break;

                    case 'userManagementEdit':
                        $rule = [
                            'name' => 'required',
                            'email' => 'required',
                            'password' => 'required',
                            'phone_number' => 'required',
                            'date_of_birth' => 'required',
                            'address' => 'required',
                            'gender' => 'required',
                            'image' => 'required',
                            'status' => 'required'
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
            'name.required' => 'Tên người dùng không được để trống',
            'email.required' => 'Email người dùng không được để trống',
            'password.required' => 'Mật khẩu người dùng không được để trống',
            'phone_number.required' => 'Số điện thoại người dùng không được để trống',
            'date_of_birth.required' => 'Ngày người dùng sinh không được để trống',
            'address.required' => 'Địa chỉ người dùng không được để trống',
            'gender.required' => 'Giới tính người dùng không được để trống',
            'image.required' => 'Ảnh đại diện người dùng không được để trống',
            'status.required' => 'Trạng thái người dùng không được để trống'
        ];
    }
}
