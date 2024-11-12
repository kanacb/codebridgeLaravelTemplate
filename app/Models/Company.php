<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = "companies";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'companyNo',
        'newCompanyNumber',
        'DateIncorporated',
        'isdefault'
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
    public function companyAddresses(): HasMany
    {
        return $this->hasMany(CompanyAddress::class);
    }
    public function companyPhones(): HasMany
    {
        return $this->hasMany(CompanyPhone::class);
    }
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
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
