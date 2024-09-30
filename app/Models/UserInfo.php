<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'browser_name',
        'browser_version',
        'device_type',
        'current_date_time',
        'country',
        'city',
        'latitude',
        'longitude',
    ];
}
