<?php

namespace App\Services;

use App\Models\Plan;

class PlansService
{
    protected $plan;
    
    public function __construct()
    {
        //$this->plan = $plan;
    }

    public function createPlan($name, $desc, $goals, $userId)
    {
        $plan = new Plan;
        $plan->name = $name;
        $plan->description = $desc;
        $plan->goals = $goals;
        $plan->user_id = $userId;
        $plan->save();

        return $plan;
    }

    public function updatePlan($planId, $name, $desc, $goals, $userId)
    {
        $plan = Plan::find($planId);
        $plan->name = $name;
        $plan->description = $desc;
        $plan->goals = $goals;
        $plan->user_id = $userId;
        $plan->save();

        return $plan;
    }

    public function publish($planId)
    {
        $plan = Plan::find($planId);
        
        if ($plan)
        {
            $plan->status = 'published';
            $plan->save();
        }
    }

    public function unpublish($planId)
    {
        $plan = Plan::find($planId);
        
        if ($plan)
        {
            $plan->status = 'draft';
            $plan->save();
        }
    }
}
