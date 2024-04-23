<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EnviosController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProductosController;
use App\Http\Middleware\isAdmin;

Route::middleware('guest')->group(function(){

    Route::get("/register", function(){ return view('register'); });
    Route::get("/login", function(){ return view('login'); })->name('login');
    Route::post('login', [IndexController::class, 'login'])->name('auth.login');

});

Route::middleware('auth')->group(function(){
    Route::get('/', [IndexController::class, 'index'])->name('dashboard');
    Route::get('/logout', [IndexController::class, 'logout'])->name('logout');

    Route::get('/pedidos', [PedidosController::class, 'index'])->name('pedidos.enlistar');
    Route::post('/pedidos', [PedidosController::class, 'getInfo'])->name('pedidos.getInfo');

    Route::get('/pedidos/edit/{id?}', [PedidosController::class, 'getInfo'])->name('pedidos.edit');
    Route::get('/pedidos/nuevo', [PedidosController::class, 'createIndex'])->name('pedidos.crear');
    Route::get('/pedidos/delete/{id?}', [PedidosController::class, 'delete'])->name('pedidos.delete');
    Route::get('/pedidos/nota/download/{id}', [PedidosController::class, 'download'])->name('pedidos.download');
    Route::post('/pedidos/update', [PedidosController::class, 'update'])->name('pedidos.update');
    Route::post('/pedidos/producto/add', [PedidosController::class, 'add'])->name('pedidos.add.producto');
    Route::post('/pedidos/producto/delete', [PedidosController::class, 'deleteProducto'])->name('pedidos.delete.producto');
    Route::post('/pedidos/save', [PedidosController::class, 'create'])->name('pedidos.create');

    Route::get('/direcciones_envios/get/{id?}', [EnviosController::class, 'get'])->name('envios.get');
    Route::post('/direcciones_envios/update', [EnviosController::class, 'update'])->name('envios.update');

    Route::get("/clientes", [ClientesController::class, 'index'])->name("clientes.index");
    Route::get("/clientes/edit/{id?}", [ClientesController::class, 'show'])->name("clientes.show");
    Route::get("/clientes/delete/{id?}", [ClientesController::class, 'delete'])->name("clientes.delete");
    Route::get("/clientes/create", [ClientesController::class, 'create'])->name("clientes.create");
    Route::post("/clientes/save", [ClientesController::class, 'save'])->name("clientes.save");
    Route::post('/clientes/update', [ClientesController::class, 'update'])->name('clientes.update');

    Route::get("/productos/xml/{id?}", [ProductosController::class, 'xml'])->name("productos.xml");
    Route::get("/productos", [ProductosController::class, 'index'])->name("productos.index");
    Route::get("/productos/edit/{id?}", [ProductosController::class, 'show'])->name("productos.show");
    Route::get("/productos/create", [ProductosController::class, 'create'])->name("productos.create");
    Route::post("/productos/save", [ProductosController::class, 'save'])->name("productos.save");
    Route::post("/productos/update", [ProductosController::class, 'update'])->name("productos.update");

    Route::get("/envios", [EnviosController::class, 'index'])->name("envios.index");
    Route::get("/envios/edit/{id?}", [EnviosController::class, 'show'])->name("envios.show");
    Route::get("/envios/create", [EnviosController::class, 'create'])->name("envios.create");
    Route::post("/envios/save", [EnviosController::class, 'save'])->name("envios.save");
    Route::post('/envios/update', [EnviosController::class, 'update'])->name('envios.update');

    Route::get("/php", function(){
        return phpinfo();
    });
});
