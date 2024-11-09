<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'contact_number',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function enrollee()
    {
        return $this->hasMany(Enrollee::class);
    }

    public function user_enrollee(){
        return $this->hasOne(Enrollee::class);
    }

    public function user_session()
    {
        return $this->hasMany(UserSession::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversations', 'user1_id', 'user2_id');
    }
    
    public function instructor_info(){
        return $this->hasOne(Instructor::class);
    }

    public function device_tokens(){
        return $this->hasMany(DeviceToken::class);
    }

    public function has_ongoing_course(){
        return $this->enrollee()
        ->whereHas('batch', function ($query) {
            $query->whereNull('completed_at');
        })
        ->exists();
    }

    public function get_profile_picture()
    {
        // Get the latest enrollee for the user
        $latestEnrollee = $this->enrollee()->latest()->first(); // Fetch the latest enrollee

        if ($latestEnrollee) {
            // Fetch the latest submitted enrollee files for the specific enrollee
            $profilePicture = $latestEnrollee->enrollee_files_submitted()
                ->where('credential_type', 'id_picture') // Filter by credential type
                ->latest() // Get the latest one
                ->first();

            if ($profilePicture) {
                // Construct the path to the profile picture
                $path = "storage/enrollee_files/{$latestEnrollee->course_id}/{$latestEnrollee->id}/id_picture/{$profilePicture->folder}/{$profilePicture->filename}";

                return asset($path); // Return the full URL to the image
            }
        }

        // Return a default profile picture if not found
        return asset('images/temporary/profile.png'); 
    }

    public function completed_course_count(){
        return $this->enrollee()
        ->whereHas('batch', function ($query) {
            $query->whereNotNull('completed_at');
        })
        ->count();
    }



}
