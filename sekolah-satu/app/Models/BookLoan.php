<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_number",
        "user_id",
        "book_id",
        "loan_date",
        "due_date",
        "return_date",
        "status",
        "fine_amount",
        "notes"
    ];

    protected $casts = [
        "loan_date" => "date",
        "due_date" => "date",
        "return_date" => "date",
        "fine_amount" => "decimal:2"
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Helper methods
    public function generateInvoiceNumber()
    {
        $date = now()->format("Ymd");
        $lastInvoice = self::where("invoice_number", "like", "INV-{$date}-%")->orderBy("id", "desc")->first();
        
        if ($lastInvoice) {
            $lastNumber = intval(substr($lastInvoice->invoice_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, "0", STR_PAD_LEFT);
        } else {
            $newNumber = "0001";
        }
        
        return "INV-{$date}-{$newNumber}";
    }

    public function calculateFine($dailyFineAmount = 1000)
    {
        if ($this->status === "returned" || !$this->isOverdue()) {
            return 0;
        }

        $overdueDays = $this->getOverdueDays();
        return $overdueDays * $dailyFineAmount;
    }

    public function isOverdue()
    {
        return $this->status !== "returned" && Carbon::now()->gt($this->due_date);
    }

    public function getOverdueDays()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->due_date);
    }

    public function markAsReturned()
    {
        $this->update([
            "return_date" => now(),
            "status" => "returned"
        ]);

        // Increase available copies of the book
        $this->book->increaseAvailableCopies();
    }

    public function markAsOverdue()
    {
        if ($this->isOverdue() && $this->status !== "returned") {
            $this->update([
                "status" => "overdue",
                "fine_amount" => $this->calculateFine()
            ]);
        }
    }

    // Scopes
    public function scopeBorrowed($query)
    {
        return $query->where("status", "borrowed");
    }

    public function scopeOverdue($query)
    {
        return $query->where("status", "overdue")
                    ->orWhere(function($q) {
                        $q->where("status", "borrowed")
                          ->where("due_date", "<", now());
                    });
    }

    public function scopeReturned($query)
    {
        return $query->where("status", "returned");
    }

    // Boot method to auto-generate invoice number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->invoice_number)) {
                $model->invoice_number = $model->generateInvoiceNumber();
            }
        });
    }
}
