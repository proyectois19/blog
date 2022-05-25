<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        
        /* //pregunta si el valor que estoy enviando en el campo  user_id coincide con el di del usuairo auth
        if ($this->user_id == auth()->user()->id) {
            return true;
        }else{
            return false;
        } */

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        //en una variable post vamos a recuperar la info del post 
        $post=$this->route()->parameter('post');

        $rules =[
            'name'=>'required',
            'slug'=>'required|unique:posts',
            'status'=>'required|in:1,2',
            'file'=> 'image'
        ];

        if($post){
            $rules['slug']= 'required|unique:posts,slug,'. $post->id;
        }
        if ($this->status == 2) {
            // fusiona dos arrays
            $rules = array_merge($rules,[
                'category_id'=>'required',
                'tags'=>'required',
                'extract'=>'required',
                'body'=>'required',
            ]);
        }
        return $rules;
    }
}
