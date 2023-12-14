<?php


namespace App\Helpers;

use App\Models\LogActivity as ModelsLogActivity;
use Request;

class LogActivity
{

    public static function addToLog($log_name,$user_id,$user_name,$activity_type,$description)
    {
    	$log = [];
    	$log['log_name'] = $log_name;
    	$log['user_id'] = $user_id;
    	$log['user_name'] = $user_name;
    	$log['activity_type'] = $activity_type;
    	$log['description'] = $description;
    	ModelsLogActivity::create($log);
    }

    public static function logActivityLists()
    {
    	return ModelsLogActivity::latest()->get();
    }

}