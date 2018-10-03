<?php
    namespace App\Controllers;
    use App\Models\BlogPost;

    class IndexController extends BaseController {

        public function getIndex($currentPage = 1){
            $totalBlogPosts = BlogPost::count();
		    $BlogPostsPerPage = 5;
		    $totalPages = ceil( $totalBlogPosts / $BlogPostsPerPage);

		    $offset = ($currentPage - 1) * $BlogPostsPerPage;
		    $blogPosts = BlogPost::offset($offset)->limit($BlogPostsPerPage)->orderBy('id', 'desc')->get();

		    return $this->render('index.twig', [
			      	'blogPosts' => $blogPosts,
			      	'currentPage' => $currentPage,
			      	'totalPages' => $totalPages
		    ]);
		}
    }
