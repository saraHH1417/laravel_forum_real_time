<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\ReplyResource;
use App\Models\Question;
use App\Repositories\QuestionRepositoryInterface;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class QuestionController extends Controller
{

    private $repository;
    public function __construct(QuestionRepositoryInterface $repository)
    {
        $this->middleware('jwt' , ['except' => ['index' , 'show' , 'indexTwo',
            'indexThreeWithRepository' , 'indexFourWithRepositoryForResource']]);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function index(){
//
//        DB::enableQueryLog();
//        $questions_jsonn =  Question::with('replies')->latest()->get()->toArray();
//        dump($questions_jsonn);
//        die;
////        $questions = QuestionResource::collection(Question::latest()->get());
////
////                Cache::put('q1' , $questions , 60);
////        Cache::forget('q1');
////        dd(Cache::get('q1'));
//
//
//
////        $questions = Cache::remember('questions' , now()->addSeconds(10) ,
////            function (){
////                return QuestionResource::collection(Question::latest()->get());
////            });
//        if(!Redis::keys('question:*')){
//            $questions = Question::with('replies')->latest()->get();
//            $questions_json = QuestionResource::collection($questions);
//            foreach($questions as  $question){
//
//                Redis::hmset('question:' . $question->id ,  [
//                    'id' => $question->id,
//                    'title' => $question->title,
//                    'path' => $question->path,
//                    'slug' => $question->slug,
//                    'replies' => $question->replies,
//                    'reply_count' => $question->replies->count(),
//                    'body' => $question->body,
//                    'created_at' => $question->created_at->diffForHumans(),
//                    'updated_at' => $question->updated_at->diffForHumans(),
//                    'user' => $question->user->name,
//                    'user_id' => $question->user->id
//                ]);
//                Redis::expire('question:' . $question->id , 20);
//            }
////            $questions = QuestionResource::collection(Question::latest()->get());
////            $questions = QuestionResource::collection(Question::latest()->get())->toArray();
////            $questions = Question::with('replies')->latest()->get()->toArray();
//
////            Cache::put('questions' , $questions , 20);
//
//        }else{
////            $questions = Cache::get('questions');
////            $questions = Redis::hgetall('questions');
//            $keys = Redis::keys('question:*');
//
//            $questions_json = [];
//            foreach ($keys as $key) {
//                $key = str_replace('laravel_database_' ,'', $key);
//                $stored = Redis::hgetall($key);
//                $questions_json[] = $stored;
//
//            }
//
//
//        }
//
//        return response()->json([
//            'queries' => DB::getQueryLog(),
//            'count' => count($questions_json),
//            'questions' => $questions_json,
//        ]);
////        return QuestionResource::collection(Question::latest()->get());
//    }
    public function index()
    {

        DB::enableQueryLog();

        $questions_json = Cache::remember('questions' , now()->addSeconds(10), function (){
            $questions = Question::with('replies')->orderBy('id' , 'desc')->paginate(10);
                return QuestionResource::collection($questions)->response()->getData(true);
        });

        return response()->json([
            'queries' => DB::getQueryLog(),
            'count' => count($questions_json['data']),
            'questions' => $questions_json,
        ]);
    }
        public function indexTwo()
        {

            DB::enableQueryLog();
            $questions_json = Cache::remember('questionsResource' , now()->addSeconds(10), function (){
//                return Question::with('replies')->paginate(10);
                return Question::with('replies')->get()->toArray();
            });
            return response()->json([
                'queries' => DB::getQueryLog(),
                'count' => count($questions_json),
                'questions' => $questions_json,
            ]);
        }

    public function indexThreeWithRepository()
    {
        DB::enableQueryLog();
        $questions_json = Cache::remember('questionsRepository' , now()->addSeconds(10), function (){
//                return Question::with('replies')->paginate(10);
            return $this->repository->getAllWithRepliesAsArray();
        });

        return response()->json([
            'queries' => DB::getQueryLog(),
            'count' => count($questions_json),
            'questions' => $questions_json,
        ]);
    }

    public function indexFourWithRepositoryForResource()
    {
        DB::enableQueryLog();

        $questions_json = Cache::remember('questionsRepositoryResource' , now()->addSeconds(10), function (){
            return $this->repository->getAllResource();
        });

        return response()->json([
            'queries' => DB::getQueryLog(),
            'count' => count($questions_json['data']),
            'questions' => $questions_json,
        ]);
    }
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
//        auth()->user()->question()->create($request->all());
//        $request->slug = Str::slug($request->name);
//        Question::create($request->all());
        $question = auth()->user()->question()->create($request->all());
        return response(new QuestionResource($question) , ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return new QuestionResource($question);
    }
//    public function show($id){
//
//        $question = Question::findOrFail($id);
//        return new QuestionResource($question);
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {

        $question->update($request->all());

        return response('Update' , ResponseAlias::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return response(ResponseAlias::HTTP_NO_CONTENT);
    }


}
