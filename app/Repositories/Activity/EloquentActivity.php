<?php

namespace App\Repositories\Activity;

use App\Services\Logging\UserActivity\Activity;

class EloquentActivity implements ActivityRepository
{
    public function log($data)
    {
        return Activity::create($data);
    }
    
	public function getLatestActivitiesForUser($userId, $activitiesCount = 10)
    {
        return Activity::where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit($activitiesCount)
            ->get();
    }

    public function paginateActivitiesForUser($userId, $perPage = 20, $search = null)
    {
        $query = Activity::where('user_id', $userId);

        return $this->paginateAndFilterResults($perPage, $search, $query);
    }

    public function paginateActivities($perPage = 20, $search = null)
    {
        $query = Activity::with('user');

        return $this->paginateAndFilterResults($perPage, $search, $query);
    }

    /**
    *=========== PRIVATE FUNCTION ==========================
    */
    private function paginateAndFilterResults($perPage, $search, $query)
    {
        if ($search) {
            $query->where('description', 'LIKE', "%$search%");
        }

        $result = $query->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        return $result;
    }
}