<?php

namespace App\Contracts\Repositories;

use App\Models\Journal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface JournalRepositoryInterface
{
    public function findById(int $id): ?Journal;

    public function createJournal(array $data): Journal;

    public function updateJournal(Journal $journal, array $data): Journal;

    public function getStudentJournals(int $userId, int $perPage = 10): LengthAwarePaginator;

    public function countUserJournals(int $userId): int;

    public function countUserJournalsByStatus(int $userId, string $status): int;

    public function hasSubmittedToday(int $userId, string $todayDate): bool;

    public function countJournalsByDate(string $date): int;

    public function getRecentJournals(int $limit = 5): Collection;

    public function getJournalsMapByDate(string $date): Collection;
}
