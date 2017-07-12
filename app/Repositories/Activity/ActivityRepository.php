<?php

namespace App\Repositories\Activity;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;

interface ActivityRepository
{
	/**
     * Get specified number of latest user activity logs.
     *
     * @param $userId
     * @param int $activitiesCount
     * @return mixed
     */
    public function getLatestActivitiesForUser($userId, $activitiesCount = 10);

}