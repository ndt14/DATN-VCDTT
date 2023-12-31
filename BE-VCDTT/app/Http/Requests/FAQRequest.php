<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class FAQRequest extends FormRequest
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
                    case 'faqManagementAdd':
                        $rule = [
                            'question' => 'required',
                            'answer' => 'required',
                        ];
                        break;

                    case 'faqManagementEdit':
                        $rule = [
                            'question' => 'required',
                            'answer' => 'required',
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
            'question.required' => 'Câu hỏi không được trống',
            'answer.required' => 'Câu trả lời không được trống'
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
