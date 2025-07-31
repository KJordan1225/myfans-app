<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreatorController extends Controller
{
    public function creatorCreatePost()
    {
        dd('Creator post creation page');        
        return view('post.create');
    }
}
