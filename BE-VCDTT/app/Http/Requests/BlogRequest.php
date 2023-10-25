<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class BlogRequest extends FormRequest
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
                    case 'blogManagementAdd':

                        // xây dựng validate

                        $rule = [
                            'title' => 'required',
                            'author' => 'required',
                            'short_desc' => 'required',
                            'main_img' => 'required',
                        ];

                        break;

                    case 'blogManagementEdit':

                        // xây dựng validate

                        $rule = [
                            'title' => 'required',
                            'author' => 'required',
                            'short_desc' => 'required',
                            'main_img' => 'required',
                        ];

                        break;

                endswitch;
                break;
        endswitch;
        return $rule;
    }

    public function messages()
    {
        return
            [
                'title.required' => 'Không được bỏ trống tiêu đề!',
                'author.required' => 'Không được bỏ trống tác giả!',
                'short_desc.required' => 'Không được bỏ trống miêu tả ngắn!',
                'main_img.required' => 'Không được bỏ trống ảnh!',
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

