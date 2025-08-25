<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "author",
        "isbn",
        "publisher",
        "publication_year",
        "category",
        "description",
        "total_copies",
        "available_copies",
        "shelf_location",
        "is_active"
    ];

    protected $casts = [
        "is_active" => "boolean"
    ];

    // Relationships
    public function bookLoans()
    {
        return $this->hasMany(BookLoan::class);
    }

    public function activeBorrows()
    {
        return $this->hasMany(BookLoan::class)->whereIn("status", ["borrowed", "overdue"]);
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->available_copies > 0 && $this->is_active;
    }

    public function getBorrowedCopiesAttribute()
    {
        return $this->total_copies - $this->available_copies;
    }

    public function decreaseAvailableCopies()
    {
        if ($this->available_copies > 0) {
            $this->decrement("available_copies");
            return true;
        }
        return false;
    }

    public function increaseAvailableCopies()
    {
        if ($this->available_copies < $this->total_copies) {
            $this->increment("available_copies");
            return true;
        }
        return false;
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where("available_copies", ">", 0)->where("is_active", true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where("category", $category);
    }
}
