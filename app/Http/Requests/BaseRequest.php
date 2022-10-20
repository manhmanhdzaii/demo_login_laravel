<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Exception;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $method = $this->getMethod();
        switch ($method) {
            case 'POST':
                return  $this->ruleSPost();
            case 'GET':
                return $this->ruleSGet();
            case 'PUT':
                return $this->rulesPut();
            default:
                throw new Exception('Not define');
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rulesPost()
    {
        return [
            //
        ];
    }
    public function rulesGet()
    {
        return [
            //
        ];
    }
    public function rulesPut()
    {
        return [
            //
        ];
    }
}