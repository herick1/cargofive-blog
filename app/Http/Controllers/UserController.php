<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Posts;

use Illuminate\Http\Request;

class UserController extends Controller
{
  /*
	 * Display the posts of a particular user
	 * 
	 * @param int $id
	 * @return Response
	 */
  public function logout()
  {
    Auth::logout();
    return redirect('/');
  }


  /*
	 * Display the posts of a particular user
	 * 
	 * @param int $id
	 * @return Response
	 */
  public function user_posts($id)
  {
    //
    $posts = Posts::where('author_id', $id)->where('status', 'published')->orderBy('updated_at', 'desc')->paginate(5);
    $title = User::find($id)->name;
    return view('home')->withPosts($posts)->withTitle($title);
  }

  public function user_posts_all(Request $request)
  {
    //
    $user = $request->user();
    $posts = Posts::where('author_id', $user->id)->orderBy('updated_at', 'desc')->paginate(5);
    $title = $user->name;
    return view('home')->withPosts($posts)->withTitle($title);
  }

  public function user_posts_draft(Request $request)
  {
    //
    $user = $request->user();
    $posts = Posts::where('author_id', $user->id)->where('status',  '!=','published')->orderBy('updated_at', 'desc')->paginate(5);
    $title = $user->name;
    return view('home')->withPosts($posts)->withTitle($title);
  }

  /**
   * profile for user
   */
  public function profile(Request $request)
  {
    $id = Auth::user()->id; 
    $data['user'] = User::find($id);
    if (!$data['user'])
      return redirect('/');

    if ($request->user() && $data['user']->id == $request->user()->id) {
      $data['author'] = true;
    } else {
      $data['author'] = null;
    }
    $data['comments_count'] = $data['user']->comments->count();
    $data['posts_count'] = $data['user']->posts->count();
    $data['posts_active_count'] = $data['user']->posts->where('status', 'published')->count();
    $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
    $data['latest_posts'] = $data['user']->posts;
    $data['latest_comments'] = $data['user']->comments->take(5);
    return view('admin.profile', $data);
  }

 public function profileWithoutLogin(Request $request, $id)
  {
    $data['user'] = User::find($id);
    if (!$data['user'])
      return redirect('/');

    if ($request->user() && $data['user']->id == $request->user()->id) {
      $data['author'] = true;
    } else {
      $data['author'] = null;
    }
    $data['comments_count'] = $data['user']->comments->count();
    $data['posts_count'] = $data['user']->posts->count();
    $data['posts_active_count'] = $data['user']->posts->where('status', 'published')->count();
    $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
    $data['latest_posts'] = $data['user']->posts->where('status', 'published');
    $data['latest_comments'] = $data['user']->comments->take(5);
    return view('admin.profile', $data);
  }
}