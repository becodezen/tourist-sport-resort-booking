<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->slugify($value);
    }

    protected function slugify($name)
    {
        $slug = str_replace(' ', '-', strtolower($name));

        $slug = str_replace('.', '', $slug);

        $customer = Customer::where('slug', $slug)->get();

        if (count($customer) > 0) {
            $slug = $slug.'-'.$customer->count();
        }

        return $slug;
    }

    public function profile()
    {
        return $this->hasOne(CustomerProfile::class, 'customer_id', 'id');
    }
}
