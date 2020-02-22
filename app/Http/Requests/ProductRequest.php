<?php


// php artisan make:request ProductRequest
// 这个request其实就是用来产生post方法，比如新增加一个product
// 需要存的东西，别人的create个东西，我们要store用的是request
// 查询展示index啥的就是我们有什么资源resource给别人看


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //这个地方本来是false，现在就是让每一个post新建的product都直接通过但下面会写rules
        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:products',
            'description' => 'required',
            'price' => 'required|max:10',
            'stock' => 'required|max:6',
            'discount' => 'required|max:2',
        ];
    }


    // public function attributes()
    // {
    //     return [
    //         'required' => '必须',
    //         'max' => '大于'
    //     ];
    // }

    // public function messages()
    // {
    //     return [
    //         // 'tag.required' => '必须选择标签',
    //     ];
    // }
}
