<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\QueryLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FanaticoController extends Controller
{
    public function misConsultas()
    {
        $consultas = QueryLog::where('user_id', Auth::id())->get();
        return response()->json($consultas);
    }

    public function editarPerfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'nullable|st|ring|min:6',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json(['message' => 'Perfil actualizado']);
    }
}
