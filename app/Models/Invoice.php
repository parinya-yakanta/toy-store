<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'invoice_no',
        'invoice_date',
        'due_date',
        'company_id',
        'customer_id',
        'sub_total',
        'discount',
        'total',
        'status',
        'payment',
        'deleted_by',
    ];
}
