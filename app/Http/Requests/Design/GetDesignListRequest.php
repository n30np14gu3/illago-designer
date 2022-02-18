<?php

namespace App\Http\Requests\Design;

use App\Exceptions\InvalidRequestArgsException;
use App\Http\Modules\RestApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class GetDesignListRequest extends FormRequest
{
    use RestApiResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'exists:design_presets,id',
            'count' => 'int|min:1',
            'offset' => 'int|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'exists' => 'Пресет с таким id не найден!',
            'count.int' => 'Кол-во должно быть целым числом',
            'count.min' => 'Минимальное кол-во: 1',

            'offset.int' => 'Смещение должно быть целым числом',
            'offset.min' => 'Минимальное смещение: 0',
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
