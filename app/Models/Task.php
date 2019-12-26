<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    public static $task_status_arr = [
        'OPENED' => '开启',
        'CLOSED' => '关闭',
        'DOING' => '处理中'
    ];

    public static $task_type_arr = [
        'BUG' => 'BUG',
        'CONFIG' => '配置',
        'REQUIREMENT' => '需求',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
