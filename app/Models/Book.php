<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['isbn', 'title', 'year', 'publisher_id', 'author_id', 'catalog_id', 'qty', 'price'];

    public function publishers() {
        return $this->belongsTo(Publisher::class);
    }

    public function authors() {
        return $this->belongsTo(Author::class);
    }

    public function catalogs() {
        return $this->belongsTo(Catalog::class);
    }

    public function transactionsdetails() {
        return $this->hasMany(TransactionDetail::class);
    }
}
