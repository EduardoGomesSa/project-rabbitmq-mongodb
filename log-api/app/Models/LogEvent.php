<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class LogEvent extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'log_events';

    protected $fillable = ['event', 'payload', 'created_at'];
}
