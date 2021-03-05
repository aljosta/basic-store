<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = "id";

    protected $fillable = [
        "customer_name",
        "customer_email",
        "customer_mobile",
        "status",
        "created_at",
        "updated_at",
        "request_id"
    ];
}


