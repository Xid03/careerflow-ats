<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'job_title',
        'date_applied',
        'status',
        'expected_salary',
        'offered_salary',
        'job_location',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_applied' => 'date',
            'expected_salary' => 'decimal:2',
            'offered_salary' => 'decimal:2',
        ];
    }

    public static function statuses(): array
    {
        return [
            'Wishlist',
            'Applied',
            'Screening',
            'Interview',
            'Offer',
            'Rejected',
            'Withdrawn',
        ];
    }

    public static function statusBadgeClasses(string $status): string
    {
        return match ($status) {
            'Wishlist' => 'bg-violet-100 text-violet-700',
            'Applied' => 'bg-blue-100 text-blue-700',
            'Screening' => 'bg-amber-100 text-amber-700',
            'Interview' => 'bg-sky-100 text-sky-700',
            'Offer' => 'bg-emerald-100 text-emerald-700',
            'Rejected' => 'bg-rose-100 text-rose-700',
            'Withdrawn' => 'bg-slate-200 text-slate-700',
            default => 'bg-slate-100 text-slate-700',
        };
    }

    public static function statusBarClasses(string $status): string
    {
        return match ($status) {
            'Wishlist' => 'bg-violet-500',
            'Applied' => 'bg-blue-500',
            'Screening' => 'bg-amber-500',
            'Interview' => 'bg-sky-500',
            'Offer' => 'bg-emerald-500',
            'Rejected' => 'bg-rose-500',
            'Withdrawn' => 'bg-slate-500',
            default => 'bg-slate-500',
        };
    }

    public static function statusHexColor(string $status): string
    {
        return match ($status) {
            'Wishlist' => '#8b5cf6',
            'Applied' => '#3b82f6',
            'Screening' => '#f59e0b',
            'Interview' => '#0ea5e9',
            'Offer' => '#10b981',
            'Rejected' => '#f43f5e',
            'Withdrawn' => '#64748b',
            default => '#94a3b8',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class)->latest('interview_date');
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class)->orderBy('remind_at');
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ApplicationStatusHistory::class)->latest('changed_at');
    }

    public function scopeOwnedBy(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $builder) use ($term) {
            $builder
                ->where('job_title', 'like', '%'.$term.'%')
                ->orWhereHas('company', function (Builder $companyQuery) use ($term) {
                    $companyQuery->where('name', 'like', '%'.$term.'%');
                });
        });
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if (blank($status)) {
            return $query;
        }

        return $query->where('status', $status);
    }
}
