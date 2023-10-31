<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllocationRequest extends FormRequest
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
                    case 'allocationManagementAdd':
                        $rule =  [
                            'user' => 'required',
                            'role' => 'required'
                        ];
                        break;

                    case 'allocationManagementEdit':
                        $rule =  [
                            'user' => 'required',
                            'role' => 'required'
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
            'user.required' => 'Vui lòng chọn user muốn cấp quyền',
            'role.required' => 'Vui lòng chọn vai trò cho user' 
        ];
    }
}
