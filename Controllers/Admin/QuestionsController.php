<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Question\BulkDestroyQuestion;
use App\Http\Requests\Admin\Question\DestroyQuestion;
use App\Http\Requests\Admin\Question\IndexQuestion;
use App\Http\Requests\Admin\Question\StoreQuestion;
use App\Http\Requests\Admin\Question\UpdateQuestion;
use App\Models\Question;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuestionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexQuestion $request
     * @return array|Factory|View
     */
    public function index(IndexQuestion $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Question::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['answer_type', 'id', 'order', 'question', 'parent_id', 'type', 'with_text_answer'],

            // set columns to searchIn
            ['answer_type', 'id', 'question->en', 'type']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return ['data' => $data];
        }

        return view('admin.question.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.question.create');

        return view('admin.question.create', [
            'types' => json_encode(Question::ALL_QUESTION_TYPES),
            'answer_type' => json_encode(Question::ALL_ANSWER_TYPES),
            'parent_question' => Question::whereNull('parent_id')
                ->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestion $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreQuestion $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Question
        $question = Question::create($sanitized);
        $this->updateAnswers($question, $sanitized['answers']);

        if ($request->ajax()) {
            return ['redirect' => url('admin/questions'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/questions');
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return void
     * @throws AuthorizationException
     */
    public function show(Question $question)
    {
        $this->authorize('admin.question.show', $question);
        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Question $question)
    {
        $this->authorize('admin.question.edit', $question);

        return view('admin.question.edit', [
            'question' => $question,
            'types' => json_encode(Question::ALL_QUESTION_TYPES),
            'answer_type' => json_encode(Question::ALL_ANSWER_TYPES),
            'parent_question' => Question::whereNull('parent_id')
                ->where('id', '!=', $question->id)
                ->get(),
            'answers' => $question->answers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuestion $request
     * @param Question $question
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateQuestion $request, Question $question)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $this->updateAnswers($question, $sanitized['answers']);

        // Update changed values Question
        $question->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/questions'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/questions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyQuestion $request
     * @param Question $question
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyQuestion $request, Question $question)
    {
        $question->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyQuestion $request
     * @return Response|bool
     * @throws Exception
     */
    public function bulkDestroy(BulkDestroyQuestion $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Question::whereIn('id', $bulkChunk)->delete();
                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    /**
     * @param Question $question
     * @param array $answers
     */
    private function updateAnswers(Question $question, array $answers)
    {
        $oldIds = [];
        foreach ($answers as $answer) {
            if ($answer['id']) {
                $oldIds[] = $answer['id'];
            }
        }
        $question->answers()->whereNotIn('id', $oldIds)->delete();

        foreach ($answers as $answer) {
            if ($answer['id']) {
                $question->answers()->where('id', $answer['id'])->update([
                    'answer' => $answer['answer']
                ]);
            } else {
                $question->answers()->create([
                    'answer' => $answer['answer']
                ]);
            }
        }
    }
}
