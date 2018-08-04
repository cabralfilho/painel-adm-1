<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UsuarioController extends Controller
{
    public function index(){
        return view('admin.usuario.novoUsuario');
    }

    public function salvarUsuario(Request $request){
        
        $novoUsuario = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ];

        if(User::where('email','=', $novoUsuario['email'])->count()){
            $usuario = User::where('email','=', $novoUsuario['email'])->first();
            $usuario->update($novoUsuario);
        }
        else
        {
            User::create($novoUsuario);
            \Session::flash('mensagem_sucesso','Usuário criado com sucesso!');

        }

        return redirect()->route('admin.usuario');
    }

    public function verUsuario(){

        $verUsuario = User::all();

        return view('admin.usuario.usuario',compact('verUsuario'));
    }

    public function editar($id){
        $editarUsuario = User::find($id);

        return view ('admin.usuario.editarUsuario', compact('editarUsuario'));
    }

    public function atualizar(Request $req,$id){
        $dados = $req->all();

        User::find($id)->update($dados);

        \Session::flash('mensagem_sucesso','Nome do usuário alterado com sucesso');

        return redirect()->route('admin.usuario');
    }

    public function deletar($id){
        User::find($id)->delete();

        \Session::flash('mensagem_sucesso','Usuário apagado com sucesso!');

        return redirect()->route('admin.usuario');
    }

    public function perfil(){
        return view ('admin.perfil.meuperfil');
    }

}
