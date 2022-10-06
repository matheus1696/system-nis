<?php

namespace App\Http\Controllers\User\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;

class ProfileController extends Controller
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
        $title = 'Meu Perfil';
        $users = Auth::user();

        return view('views.user.profile.index_profile',[
            'title'=>$title,
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

        return redirect()->route('profile.index',['profile'=>$id]);
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
