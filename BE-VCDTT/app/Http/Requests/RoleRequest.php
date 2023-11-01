<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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

        $rule = [];
        $currentAction = $this->route()->getActionMethod();

        switch ($this->method()):
            case 'POST':
                switch ($currentAction):
                    case 'roleManagementAdd':
                        $rule =  [
                            'name' => 'required|unique:roles',
                            'permission' => 'required'
                        ];
                        break;

                    case 'roleManagementEdit':
                        $rule =  [
                            'name' => 'required',
                            'permission' => 'required'
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
            'name.required' => 'Không được bỏ trống tên vai trò',
            'name.unique' => 'Tên vai trò này đã tồn tại',
            'permission.required' => 'Hãy lựa chọn quyền ứng với vai trò'
        ];
    }
}
