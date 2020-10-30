<?php

use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UsuarioController::class, 'index']);

Route::get('/signup', [UsuarioController::class, 'store']);

Route::get('/login', function(Request $request){
    $contrasenaCifrada = DB::table('usuarios')
    ->select('contrasena')
    ->where('nombreUsuario', $request->nombreUsuario)
    ->get();

    $usuario = DB::table('usuarios')->where([
        ['nombreUsuario', '=', $request->nombreUsuario],
        ['contrasena', '=', Hash::check($request->contrasena, $contrasenaCifrada)],
    ])->get()
    ->first();

    if($usuario != null):
        if($usuario->esAdministrador == 1):
            return 'Usuario administrador autenticado.';
        endif;
            return 'Usuario cliente autenticado.';
    endif;
        return 'Nombre de usuario o contraseña incorrecta.';
});