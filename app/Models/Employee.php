<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class Employee extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = "employees";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'empNo',
'name',
'fullname',
'dateJoined',
'dateTerminated',
'resigned',
'empGroup',
'empCode'
    ];

    public function company(){
                return $this->belongsTo(Company::class, 'id');}

public function department(){
                return $this->belongsTo(Department::class, 'id');}

public function section(){
                return $this->belongsTo(Section::class, 'id');}

public function position(){
                return $this->belongsTo(Position::class, 'id');}

public function supervisor(){
                return $this->belongsTo(Employee::class, 'id');}

    
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
