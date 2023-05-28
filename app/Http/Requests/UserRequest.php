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
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'unique:users'],
      'password' => ['required']
    ];
  }

  public function messages(): array
  {
    return [
      'name.required' => 'A name is required',
      'email.required' => 'A email is required',
      'password.required' => 'A password is required'
    ];
  }
}
