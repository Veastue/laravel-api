<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.customerId' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'], 
            '*.status' => ['required', Rule::in(['P', 'V', 'B' , 'p', 'v', 'b'])],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate' => ['nullable', 'date_format:Y-m-d H:i:s']
        ];
    }

    protected function prepareForValidation(){
        $data = [];

        foreach($this->toArray() as $obj){
            $obj['customer_id'] = $obj['customerId'] ?? null;
            $obj['billed_date'] = $obj['billedDate'] ?? null;
            $obj['paid_date'] = $obj['paidDate'] ?? null;

            $data[] = $obj;
        }

        /* foreach ($this->all() as $key => $value) {
            $data[$key]['customer_id'] = $value['customerId'] ?? null;
            $data[$key]['billed_date'] = $value['billedDate'] ?? null;
            $data[$key]['paid_date'] = $value['paidDate'] ?? null;
        } */

        $this->merge($data);
    }
}
