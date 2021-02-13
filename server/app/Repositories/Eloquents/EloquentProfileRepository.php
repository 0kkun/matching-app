<?php

namespace App\Repositories\Eloquents;

use App\Models\Profile;
use App\Repositories\Contracts\ProfileRepository;

class EloquentProfileRepository implements ProfileRepository
{
    protected $profiles;

    /**
    * @param object $users
    */
    public function __construct(
        Profile $profiles
    )
    {
        $this->profiles = $profiles;
    }
}