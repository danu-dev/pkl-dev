<?php

namespace App\Repositories;

use App\Contracts\Repositories\JournalRepositoryInterface;
use App\Models\Journal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class JournalRepository implements JournalRepositoryInterface
{
    public function findById(int $id): ?Journal
    {
        return Journal::find($id);
    }

    public function createJournal(array $data): Journal
    {
        return Journal::create($data);
    }

    public function updateJournal(Journal $journal, array $data): Journal
    {
        $journal->update($data);

        return $journal;
    }

    public function getStudentJournals(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Journal::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function countUserJournals(int $userId): int
    {
        return Journal::where('user_id', $userId)->count();
    }

    public function countUserJournalsByStatus(int $userId, string $status): int
    {
        return Journal::where('user_id', $userId)->where('status', $status)->count();
    }

    public function hasSubmittedToday(int $userId, string $todayDate): bool
    {
        return Journal::where('user_id', $userId)->where('date', $todayDate)->exists();
    }

    public function countJournalsByDate(string $date): int
    {
        return Journal::where('date', $date)->count();
    }

    public function getRecentJournals(int $limit = 5): Collection
    {
        return Journal::with('user:id,name')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getJournalsMapByDate(string $date): Collection
    {
        return Journal::where('date', $date)
            ->get()
            ->keyBy('user_id');
    }
}
