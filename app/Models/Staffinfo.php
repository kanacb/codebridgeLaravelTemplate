<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staffinfo extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = "staffinfo";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'empno',
        'name',
        'namenric',
        'compcode',
        'compname',
        'deptcode',
        'deptdesc',
        'sectcode',
        'sectdesc',
        'designation',
        'email',
        'resign',
        'supervisor',
        'datejoin',
        'empgroup',
        'empgradecode',
        'terminationdate'
    ];

    public function superior(): HasMany
    {
        return $this->hasMany(Superior::class);
    }

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
    protected $hidden = [];

    public $timestamps = true;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
