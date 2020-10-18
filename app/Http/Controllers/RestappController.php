<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Article;

class RestappController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(
            [
                'users' => $users,
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(1);
        $articles = $user->articles;
        return view('rest.create', [
            'articles' => $articles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'prefecture_id' => 'required|max:1',
            'company_type_id' => 'required|max:1',
            'phase_id' => 'required|max:1',
            'question_content' => 'required|max:1000',
            'other_information' => 'required|max:1000',
            'impression' => 'required|max:1000',
        ]);

        User::find(1)->articles()->create([
            'prefecture_id' => $request->prefecture_id,
            'company_type_id' => $request->company_type_id,
            'phase_id' => $request->phase_id,
            'question_content' => $request->question_content,
            'other_information' => $request->other_information,
            'impression' => $request->impression,
        ]);

        $articles = User::find(1)->articles;

        return response()->json(
            [
                'articles' => $articles,
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        //ユーザーが投稿した記事も取得する
        $articles = $user->articles;
        return response()->json(
            [
                'user' => $user,
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articles = Article::find($id);
        $user = $articles->user;

        if ($user->id == 1) {
            $articles->delete();
        }

        $articles = $user->$articles;

        return response()->json(
            [
                'articles' => $articles,
            ],
            200,
            [],
            JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT
        );
    }
}
