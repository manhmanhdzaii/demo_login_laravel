<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Exception;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $method = $this->getMethod();
        switch ($method) {
            case 'POST':
                return  $this->rulerPost();
                break;
            case 'GET':
                return $this->rulerGet();
                break;
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
    public function rules()
    {
        return [
            //
        ];
    }
}