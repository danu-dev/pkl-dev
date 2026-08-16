<?php

namespace App\Contracts\Services;

interface AdminDashboardServiceInterface
{
    public function getDashboardOverview(): array;
}
