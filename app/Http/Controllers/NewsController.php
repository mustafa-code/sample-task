<?php

namespace App\Http\Controllers;

use App\Events\NewsCreated;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index(){
        $news = News::all();
        return view("news.index")->with("news", $news);
    }

    public function create(){
        return view("news.create");
    }

    public function store(StoreNewsRequest $request){
        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
        $news->user_id = $request->user()->id;
        $news->save();
        return redirect(route("news.index"));
    }

    public function show($id){
        $news = News::find($id);
        return view("news.show")->with("news_item", $news);
    }

    public function edit($id){
        $news = News::find($id);
        if($news->user_id != Auth::user()->id){
            return redirect(route("news.show", $id));
        }
        return view("news.edit")->with("news", $news);
    }

    public function update(UpdateNewsRequest $request, $id){
        $news = News::find($id);
        if($news->user_id != $request->user()->id){
            return redirect(route("news.show", $id));
        }
        $news->title = $request->title;
        $news->content = $request->content;
        $news->update();
        return redirect(route("news.show", $id));
    }

    public function destroy($id){
        $news = News::find($id);
        if($news->user_id != Auth::user()->id){
            return redirect(route("news.show", $id));
        }
        $news->delete();
        return redirect(route("news.index"));
    }

    public function delete_old_news(){
        $now_before_14_days = Carbon::now()->subDays(14);
        $affected_rows = News::where("created_at", "<", $now_before_14_days)->delete();
        return response()->json([
            "status" => true,
            "message" => "Old news deleted successfully",
            "deleted_rows" => $affected_rows,
        ]);
    }
}
