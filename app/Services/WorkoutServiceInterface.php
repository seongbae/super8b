<?php

namespace App\Services;

interface WorkoutServiceInterface
{
    public function createPlan($name, $desc, $goals, $userId);
    public function updatePlan($planId, $name, $desc, $goals, $userId);
    public function deletePlan($planId);
    
    public function publish($planId);
    public function unpublish($planId);

    public function addWorkoutToPlan($plan, $workout);
    public function removeWorkoutFromPlan($plan, $planWorkoutId);
}
