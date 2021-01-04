<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyPositionChangeApplyRequest extends FormRequest
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
            //
        ];
    }

    /**
     * SkyIdを取得する
     *
     * @return int
     */
    public function getSkyId() :int
    {
        return $this->sky_id;
    }

    /**
     * PositionIdを取得する
     *
     * @return string
     */
    public function getPositionId() :string
    {
        return $this->position_id;
    }
}
