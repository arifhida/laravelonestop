<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productpost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'category_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'downloadurl' => 'required',
            'price' => 'required'            
        ];
        $photos = count($this->input('images'));
        foreach(range(0,$photos) as $index){
            $rules['images.' . $index] = 'image|mimes:jpeg,bmp,png|max:2000';
        }
        return $rules;
    }
}
