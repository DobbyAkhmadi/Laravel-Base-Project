<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $role_name
 * @property mixed $permissions
 */
class AssignPermissionRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'role_name' => 'required',
            'permissions' => 'required',
        ];
    }
}
