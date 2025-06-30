<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterJenis extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'master_jenis';
    protected $guarded = ['id'];
    public function getField()
    {
        return $this->belongsTo(AjustField::class, 'id', 'JenisSurat');
    }
}
