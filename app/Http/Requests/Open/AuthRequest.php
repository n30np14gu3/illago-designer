<?php

namespace App\Http\Requests\Open;

use App\Exceptions\InvalidRequestArgsException;
use App\Http\Modules\RestApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    use RestApiResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
          'required' => 'Данное поле является обязательным',
          'exists' => 'Пользователь с таким email не найден'
        ];
    }

    /**
     * @throws InvalidRequestArgsException
     */
    public function failedValidation(Validator $validator)
    {
        $this->response['errors'] = $validator->errors();
        $this->response['message'] = $validator->errors()->first();
        throw new InvalidRequestArgsException($this->response);
    }
}
