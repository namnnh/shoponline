<?php

namespace App\Services\Logging\UserActivity;

use App\Repositories\Activity\ActivityRepository;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Logger
{
    private $request;
    private $auth;
    protected $user = null;
    private $activities;

    public function __construct(Request $request, Guard $auth, ActivityRepository $activities)
    {
        $this->request = $request;
        $this->auth = $auth;
        $this->activities = $activities;
    }

    public function log($description)
    {
        return $this->activities->log([
            'description' => $description,
            'user_id' => $this->getUserId(),
            'ip_address' => $this->request->ip(),
            'user_agent' => $this->getUserAgent()
        ]);
    }

    /**
    * ============== Privated function
    */

    private function getUserId()
    {
        if ($this->user) {
            return $this->user->id;
        }

        return $this->auth->id();
    }

    private function getUserAgent()
    {
        return substr((string) $this->request->header('User-Agent'), 0, 500);
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}