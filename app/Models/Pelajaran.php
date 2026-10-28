<?php

namespace App\Models;
;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Pelajaran extends Model
{
    use HasUuids;
    protected $table = "pelajaran";

    protected $fillable = [
        "namaPelajaran",
        "kodePelajaran",
        "usersId"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "usersId");
    } 
}
