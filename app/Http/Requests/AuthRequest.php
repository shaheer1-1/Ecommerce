<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
class AuthRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post') && $this->routeIs('register')) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => ['nullable','confirmed',Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            ];
        }

        if ($this->isMethod('post') && $this->routeIs('login')) {
            return [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ];
        }

        return [];
    }
}
