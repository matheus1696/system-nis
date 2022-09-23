<?php

namespace App\Http\Controllers\Capacitacao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\CNEP\Capacitacao\CapacitacaoModel;
use App\Models\CNEP\Capacitacao\PalestranteModel;

class PalestranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $title = 'Cadastro de Palestrante';
        $DBcapacitacoes = CapacitacaoModel::find($id);

        $forms = [
            'palestrante' => ['tag'=>'input','type'=>'text','title'=>'Nome do Palestrante','id'=>'palestrante','row'=>'col-md-8','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'','maxlength'=>'','value'=>''],
            'cpf' => ['tag'=>'input','type'=>'text','title'=>'CPF','id'=>'cpf','row'=>'col-md-4','connection'=>'','required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11','value'=>''],
        ];

        return view('cnep.capacitacao.palestrante.create',[
            'title' => $title,
            'forms' => $forms,
            'capacitacoes' => $DBcapacitacoes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //
        $DBcapacitacoes = CapacitacaoModel::find($id);

        //Cadastrando Servidor na tabela tb_servidores
            //Declarando Variáveis enviadas via POST
            $data = $request->only('palestrante','cpf');

            //Ponte para o banco via Eloquent
                $DBpalestrantes = new PalestranteModel;

            $validator = Validator::make($data, [
                'palestrante' => 'required|string|min:6',
                'cpf' => 'required|cpf',
            ]);

            if ($validator->fails()) {
                return redirect()->route('speakers.create',['qualification'=>$id])->withErrors($validator)->withInput();
            }

            //Gravando dados no banco
                foreach ($data as $key => $value){
                    $DBpalestrantes->$key = $value;
                }
                $DBpalestrantes->capacitacao_id = $id;
                $DBpalestrantes->save();

        return redirect()->route('qualifications.show',['qualification'=>$id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = 'Editar Cadastro de Palestrante';
        $DBpalestrantes = PalestranteModel::find($id);

        $forms = [
            'palestrante' => ['tag'=>'input','type'=>'text','title'=>'Nome do Palestrante','id'=>'palestrante','row'=>'col-md-8','connection'=>'','value'=>$DBpalestrantes->palestrante,'required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11'],
            'cpf' => ['tag'=>'input','type'=>'text','title'=>'CPF','id'=>'cpf','row'=>'col-md-4','connection'=>'','value'=>$DBpalestrantes->cpf,'required'=>'required','min'=>'','max'=>'','minlength'=>'11','maxlength'=>'11'],
        ];

        return view('cnep.capacitacao.palestrante.edit',[
            'title' => $title,
            'forms' => $forms,
            'palestrantes' => $DBpalestrantes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Cadastrando Servidor na tabela tb_servidores
            //Declarando Variáveis enviadas via POST
            $data = $request->only('palestrante','cpf');

            //Ponte para o banco via Eloquent
                $DBpalestrantes = PalestranteModel::find($id);

            //Gravando dados no banco
                foreach ($data as $key => $value){
                    $DBpalestrantes->$key = $value;
                }

                $DBpalestrantes->save();

        return redirect()->route('qualifications.show',['qualification'=>$DBpalestrantes->capacitacao_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $DBpalestrantes = PalestranteModel::find($id);
        $DBpalestrantes->delete();

        return redirect()->route('qualifications.show',['qualification'=>$DBpalestrantes->capacitacao_id]);
    }
}
