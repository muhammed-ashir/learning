<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VendorResetPasswordNotification;

class Vendor extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'vendor';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
    $this->notify(new VendorResetPasswordNotification($token));
    }
    
}
