<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class DynaField extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = "dyna_fields";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from',
'fromType',
'to2',
'toType',
'fromRefService',
'toRefService',
'fromIdentityFieldName',
'toIdentityFieldName',
'fromRelationship',
'toRelationship',
'duplicates'
    ];

    public function dynaLoader(){
                return $this->belongsTo(DynaLoader::class, 'id');}

    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

    public $timestamps = true;
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        
    ];
}
