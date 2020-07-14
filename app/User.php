<?php

namespace App;

use App\Notifications\UserResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

// use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;

// class User extends Authenticatable implements MustVerifyEmail
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password' ,'username','bio','website','location','Date_of_birth'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    //Send password reset notification
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function logs()
    {
        return $this->hasMany('App\Log');
    }


    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'leader_id', 'follower_id')->withTimestamps();
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'leader_id')->withTimestamps();
    }


    public function getApprovedWord($user_id)
    {
        $words_1 = \App\Word::where('added_by', $user_id)->where('status', 1)->get()->count();
        $discharges_1 = \App\Discharges::where('added_by', $user_id)->where('status', 1)->get()->count();
        $shortcuts_1 = \App\Shortcut::where('added_by', $user_id)->where('status', 1)->get()->count();
        $slang_1 = \App\Slang::where('added_by', $user_id)->where('status', 1)->get()->count();
        $terms_1 = \App\Medical::where('added_by', $user_id)->where('status', 1)->get()->count();
        $formats_1 = \App\Format::where('added_by', $user_id)->where('status', 1)->get()->count();
        $idioms_1 = \App\Idioms::where('added_by', $user_id)->where('status', 1)->get()->count();

        $result = $words_1 + $discharges_1 + $shortcuts_1 + $slang_1 + $terms_1 + $formats_1 + $idioms_1;
        return $result;

    }

    public function getPendingWord($user_id)
    {
        $words_1 = \App\Word::where('added_by', $user_id)->where('status', 0)->get()->count();
        $discharges_1 = \App\Discharges::where('added_by', $user_id)->where('status', 0)->get()->count();
        $shortcuts_1 = \App\Shortcut::where('added_by', $user_id)->where('status', 0)->get()->count();
        $slang_1 = \App\Slang::where('added_by', $user_id)->where('status', 0)->get()->count();
        $terms_1 = \App\Medical::where('added_by', $user_id)->where('status', 0)->get()->count();
        $formats_1 = \App\Format::where('added_by', $user_id)->where('status', 0)->get()->count();
        $idioms_1 = \App\Idioms::where('added_by', $user_id)->where('status', 0)->get()->count();

        $result = $words_1 + $discharges_1 + $shortcuts_1 + $slang_1 + $terms_1 + $formats_1 + $idioms_1;
        return $result;

    }

    public function getDeclinedWord($user_id)
    {
        $words_1 = \App\Word::where('added_by', $user_id)->where('status', 2)->get()->count();
        $discharges_1 = \App\Discharges::where('added_by', $user_id)->where('status', 2)->get()->count();
        $shortcuts_1 = \App\Shortcut::where('added_by', $user_id)->where('status', 2)->get()->count();
        $slang_1 = \App\Slang::where('added_by', $user_id)->where('status', 2)->get()->count();
        $terms_1 = \App\Medical::where('added_by', $user_id)->where('status', 2)->get()->count();
        $formats_1 = \App\Format::where('added_by', $user_id)->where('status', 2)->get()->count();
        $idioms_1 = \App\Idioms::where('added_by', $user_id)->where('status', 2)->get()->count();

        $result = $words_1 + $discharges_1 + $shortcuts_1 + $slang_1 + $terms_1 + $formats_1 + $idioms_1;
        return $result;

    }

 public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }
}
