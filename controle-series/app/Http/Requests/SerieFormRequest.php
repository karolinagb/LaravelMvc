<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SerieFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //todo mundo por hora está autorizado a mandar esse request
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //regras de validação
            'nome' => ['required', 'min:3']
        ];
    }

    //podemos usar esse método para personalizar nossas mensagens ou simplesmente traduzir as mensagens q vem do framework
        //diretamente no arquivo de validation em inglês ou traduzir o sistema todo
    // public function messages()
    // {
    //     //retorna um array com todas as mensagens que eu posso utilizar
    //     return[
    //         //mensagem para a condição de required do nome
    //         'nome.required' => 'O campo nome é obrigatório',
    //         //:min é o valor da validação para min
    //         'nome.min' => 'O campo nome precisa de pelo menos :min caracteres'
    //         //definir mensagem para todas as validações relacionadas a nome
    //         //'nome.*' => 'mensagem'
    //     ];
    // }
}
