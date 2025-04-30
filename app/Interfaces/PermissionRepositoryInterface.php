<?php

namespace App\Interfaces;

interface PermissionRepositoryInterface
{
    public function getAll(?string $search);

    public function getById(int $id);
}