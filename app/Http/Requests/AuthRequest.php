<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
                'password' => 'required|min:8|confirmed',
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
