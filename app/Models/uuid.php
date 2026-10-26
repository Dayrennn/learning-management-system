<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as RamseyUuid;

class uuid extends Model
{
    use HasUuids;
    
    public function newUniqueId() 
    {
        return RamseyUuid::uuid4()->toString();
    }
}
