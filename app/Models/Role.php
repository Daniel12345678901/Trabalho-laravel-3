<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use hasFactory;

    protected $table = 'table_roles';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
    
}
