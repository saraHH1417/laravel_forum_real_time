<?php

namespace App\Repositories;

use App\Http\Resources\QuestionResource;
use App\Models\Question;

class QuestionRepository implements QuestionRepositoryInterface
{

    public function getAllWithRepliesAsArray()
    {
        return Question::with('replies')->get()->toArray();
    }

    public function getAllResource()
    {
        $questions = Question::with('replies')->paginate(10);
        return QuestionResource::collection($questions)->response()->getData(true);
    }
}
