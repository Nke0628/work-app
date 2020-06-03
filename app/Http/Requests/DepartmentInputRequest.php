<?php

namespace App\Http\Requests;

use App\Package\Domain\Department\RegisterDepartmentRequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\hhmm;

class DepartmentInputRequest extends FormRequest implements RegisterDepartmentRequestInterface
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
            'department_name'   => ['required','max:255'],
            'work_time_start' => ['required','digits:4', new hhmm],
            'work_time_end' => ['required','digits:4', new hhmm],
            'break_time_start' => ['required','digits:4', new hhmm],
            'break_time_end' => ['required','digits:4', new hhmm],
        ];
    }

    /**
     * エラーメッセージ設定
     *
     * @return array
     */
    public function messages()
    {
        return [
            'department_name.required'  => '組織名称を入力してください。',
            'department_name.max'  => '組織名称は255文字以内で入力してください。',
            'work_time_start.required'  => '勤務開始時間を入力してくださ。',
            'work_time_start.digits'  => '勤務開始時間は４桁で入力してください。',
            'work_time_end.required'  => '勤務終了時間を入力してください。',
            'work_time_end.digits'  => '勤務終了時間は４桁で入力してください。',
            'break_time_start.required'  => '休憩開始開始時間を入力してください。',
            'break_time_start.digits'  => '休憩開始時間は４桁で入力してください。',
            'break_time_end.required'  => '休憩終了時間を入力してください。',
            'break_time_end.digits'  => '休憩終了時間は４桁で入力してください。',
        ];
    }

    /**
     * @return string
     */
    public function getDepartmentName(): string
    {
        return $this->input('department_name');
    }

    /**
     * @return string
     */
    public function getStartWorkTime(): string
    {
        return $this->input('work_time_start');
    }

    /**
     * @return string
     */
    public function getEndWorkTime(): string
    {
        return $this->input('work_time_end');
    }

    /**
     * @return string
     */
    public function getStartBreakTime(): string
    {
        return $this->input('break_time_start');
    }

    /**
     * @return string
     */
    public function getEndBreakTime(): string
    {
        return $this->input('break_time_end');
    }
}
