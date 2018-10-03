<?php
    namespace App\Controllers\Admin;
    use App\Controllers\BaseController;
    use App\Models\BlogPost;
    use Sirius\Validation\Validator;

    class PostController extends BaseController {
        public function getIndex(){
            $blogPosts = BlogPost::all();
            return $this->render('admin/posts.twig', ['blogPosts' => $blogPosts]);
        }

        public function getCreate(){
            return $this->render('admin/insert-post.twig');
        }

        public function postCreate(){
            $errors = [];
            $resultado = false;
            $validator = new Validator();
            $validator->add('title', 'required');
            $validator->add('content', 'required');

            if($validator->validate($_POST)){
                $blogPost = new BlogPost([
                    'title' => $_POST['title'],
                    'content' => $_POST['content']
                ]);

                if($_POST['img']){
                    $blogPost->img_url = $_POST['img'];
                }
                
                $blogPost->save();
    
                $resultado = true;
            }else{
                $errors = $validator->getMessages();
            }

            return $this->render('admin/insert-post.twig', [
                    'resultado' => $resultado,
                    'errors' => $errors
                ]);
        }
        
        public function getEdit($id){ 

            $blogPosts = BlogPost::where('id', $id)->select('title', 'img_url', 'content')->get();
            return $this->render('admin/edit-post.twig', ['blogPosts' => $blogPosts]);
        }

        public function postEdit($id){

            $errors = [];
            $resultado = false;

            $validator = new Validator();
            $validator->add('title', 'required');
            $validator->add('img', 'required');
            $validator->add('content', 'required');
          

            if ($validator->validate($_POST)) {
                
                $postTitle = $_POST['title'];
                $postImage = $_POST['img'];
                $postContent = $_POST['content'];

                $blogPosts = BlogPost::where('id', $id)->update(['title' => $postTitle, 'img_url' => $postImage, 'content' => $postContent]); 
                $resultado = true;

            }else{
                $errors = $validator->getMessages();
            }
            return $this->render('admin/edit-post.twig', [
                'blogPosts' => $blogPosts,
                'resultado' => $resultado,
                'errors'=> $errors
            ]);
        }

        public function getDelete($id){
        
            $blogPosts = BlogPost::where('id', $id)->delete();
            return $this->render('admin/delete-post.twig', ['blogPosts'=> $blogPosts]); 

        }
    }