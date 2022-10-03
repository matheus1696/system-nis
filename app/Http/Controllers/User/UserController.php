<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Permission;
use App\Models\HasPermission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Titulo da Página
            $title = 'Administração de Usuário';
            
        //Usuário Cadastrado
            $loggedId = intval(Auth::id());

        //Listando usuários do banco de dados
            $users = User::all();

        return view('views.admin.user.account.index_account',[
            'title'=>$title,
            'loggedId'=>$loggedId,
            'users'=>$users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
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
        //Titulo da Página
            $title = 'Administração de Usuário';

        //Listando dados Cadastrados no Banco de Dados
            //Listando Usuário Selecionado
                $users = User::find($id);
            //Listando Permissões Cadastradas no Banco de Dados
                $permissions = Permission::all();
            //Listando Permissões Atribuidas ao Usuários
                $hasPermissions = HasPermission::all();
        

        return view('views.admin.user.account.edit_account',[
            'title'=>$title,
            'users'=>$users,
            'permissions'=>$permissions,
            'hasPermissions'=>$hasPermissions,
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
        //Validação dos Dados Encaminhados
            $request->validate([
                'name' => ['string', 'max:255'],
                'email' => ['string', 'email', 'max:255'],
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            

        //Verificação e Alteração de Dados do Usuário
            //Verificação e Alteração da senha
                if ($request->password) {
                    $db = User::find($id);
                    $db->password = Hash::make($request->password);
                    $db->save();
                }

            //Verificação e Alteração dos Dados do Usuário
                if ($request->name) {
                    $db = User::find($id);
                    $db->name = $request->name;
                    $db->save();
                }

        return redirect()->route('account.edit',['account'=>$id]);
    }

    /**
     * Atualizar Permissão do Usuário.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function access(Request $request, $id)
    {
        //Vados Encaminhados
            $datas = $request->all();

        //Caso não seja o Administrador do Sistema (SUPER_ADM)
            if (Empty($datas['super_adm'])) {
                # code...
                $datas['super_adm'] = 'deny';
            }

        //Listando dados Cadastrados no Banco de Dados
            //Listando Permissões Cadastradas
                $Permissions = Permission::all('id','name');
            //Listando Permissões de Usuários
                $HasPermissions = HasPermission::where('model_id', $id)->get();       

        //Verificando e Alterando Permissões
            //Deletendo todas as Permissões
                HasPermission::where('model_id', $id)->delete();               
            
            //Realizando o Cadastro dos Acessos
                foreach ($Permissions as $key => $Permission) {
                    echo $Permission;
                    if ($datas[$Permission['name']] == $Permission['id']) {
                        $db = new HasPermission;
                        $db->permission_id = $datas[$Permission['name']]; 
                        $db->model_type = 'App\Models\User';          
                        $db->model_id = $id;
                        $db->save();
                    }
                }

            return redirect()->route('account.edit',['account'=>$id]);
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
    }
}
