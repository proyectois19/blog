<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    //un metodo en una policy siempre espera un parametro, en este caso el usuario autenticado
    public function author(User $user, Post $post){
        if ($user->id == $post->user_id) {
            return true;
        }else{
            return false;
        }
        
    }

    //policy para autorizar status de un post al momento de pulicarlo  ?=autenticacion opcional
    public function published(?User $user, Post $post){
        if ($post->status == 2) {
            return true;
        }else{
            return false;
        }
    }
}
