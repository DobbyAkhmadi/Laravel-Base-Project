<?php

namespace App\Models;

use Spatie\Permission\Models\Role as OriginalRole;

/**
 * @method findOrFail(mixed $id)
 * @method static where(string $string, string $string1)
 */
class Role extends OriginalRole
{
    public string $guard_name = 'api';
}