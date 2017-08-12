<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;

class TopicController extends Controller
{
    //专题详情页
    public function show(Topic $topic)
    {
        //带文章数的专题
        $topic = Topic::withCount('postTopics')->find($topic->id);

        //专题的文章列表，按照创建时间倒序排列前10个
        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();

        //属于我的文章，但是为投稿
        $myposts = \App\Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();

        $user = \Auth::user();

        return view('topic/show', compact('user', 'posts', 'myposts'));
    }

    public function submit(Topic $topic)
    {
        return;
    }
}
