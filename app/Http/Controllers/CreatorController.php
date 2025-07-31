<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreatorController extends Controller
{
    public function creatorCreatePost()
    {        
        return view('post.create');
    }
}
