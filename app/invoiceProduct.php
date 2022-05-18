<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoiceProduct extends Model
{
    protected $table = 'invoice_product';

    protected $fillable = ['invoice_id', 'product_id', 'quantity', 'subtotal'];
}
