<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        "name", "slug"
    ];
    public function members()
    {
        return $this->BelongsToMany(User::class);
    }


    public function roles()
    {
        return $this->HasMany(Role::class);
    }
    public function kategori()
    {
        return $this->HasMany(Kategori::class);
    }
    public function produks()
    {
        return $this->HasMany(Produk::class);
    }
    public function satuan()
    {
        return $this->HasMany(Satuan::class);
    }
}
