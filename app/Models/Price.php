<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $primaryKey = 'price_id';

    protected $guarded = [];
    public $timestamps = false;

    /**
     * Calculate the final price based on values tored in database
     */
    public function getFinalPriceAttribute()
    {
        return $this->gross_sum * $this->vat_rate;
    }

    /**
     * Format vat rate stored in database to a whole number with percentage sign
     */
    public function getVatRateFormattedAttribute()
    {
        return $this->vat_rate * 100 . "%";
    }
}
