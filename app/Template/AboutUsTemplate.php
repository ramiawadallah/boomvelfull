<?php 

namespace App\Template;

use Illuminate\View\View;
// use App\Post;
use App\page;
use Carbon\Carbon;
use DB;


class AboutUsTemplate extends AbstractTemplate{

	protected $view = 'aboutus';

	// protected $posts;
	protected $pages;

	public function __construct( Page $pages){
		// $this->posts = $posts;
		$this->pages = $pages;		
	}

	public function prepare(View $view, array $parameters){
		// $posts = Post::where('save_post',1)->orderBy('id', 'desc')->limit(3)->get();
		//$pages = $this->pages->where($view, $this->view)->get();
		// $view;
	}

}