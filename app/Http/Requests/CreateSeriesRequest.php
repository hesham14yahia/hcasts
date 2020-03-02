<?php

namespace App\Http\Requests;

use App\Series;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateSeriesRequest extends FormRequest
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
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ];
    }

    // upload image
    public function uploadSeriesImage()
    {
        $uploaded_image = $this->file('image');

        $this->image = $uploaded_image->storePubliclyAs('series', Str::slug($this->title) . '.' .$uploaded_image->getClientOriginalExtension());

        return $this;
    }

    // create series
    public function storeSeries()
    {
        Series::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'image_url' => $this->image
        ]);
    }
}
