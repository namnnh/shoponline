<?php

namespace App\Repositories\Activity;

use App\Services\Logging\UserActivity\Activity;

class EloquentActivity implements ActivityRepository
{
	public function getLatestActivitiesForUser($userId, $activitiesCount = 10)
    {
        return Activity::where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($activitiesCount)
            ->get();
    }
}