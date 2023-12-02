<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                    case 'cateManagementStore':

                        // xây dựng validate

                        $rule = [
                            'name' => 'required|unique:categories',
                        ];

                        break;
                    case 'cateManagementEdit':

                        // xây dựng validate

                        $rule = [
                            'name' => 'required',
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
            'name.required' => 'Tên danh mục không được trống',
            'name.unique' => 'Tên danh mục đang trùng'
        ];
    }
}
