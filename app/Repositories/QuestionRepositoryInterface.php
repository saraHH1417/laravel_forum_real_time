<?php

namespace App\Repositories;

interface QuestionRepositoryInterface
{
    public function getAllWithRepliesAsArray();

    public function getAllResource();
}
