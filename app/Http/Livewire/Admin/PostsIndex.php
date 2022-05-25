<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithPagination;

class PostsIndex extends Component
{
    use WithPagination;
    
    // livewire trata de usar estilos de livewire y le decimos que use el bootstrap
    protected $paginationTheme = "bootstrap";
    public $search;
    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {   
        $posts = Post::where('user_id',auth()->user()->id)
            ->where('name','LIKE','%' . $this->search . '%')
            ->latest('id')
            ->paginate(4);
        return view('livewire.admin.posts-index',compact('posts'));
    }
}
