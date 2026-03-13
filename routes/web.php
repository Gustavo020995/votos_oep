<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\RecintoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\ResultadoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', function () {
        return 'Solo para admins';
    });
});
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Rutas de usuarios
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    //Route::resource('users', UserController::class);


    Route::resource('users', UserController::class);
Route::resource('permissions', PermissionController::class);
  Route::resource('roles', RoleController::class);

  // Dashboard
//Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Gestión Territorial
Route::resource('departamentos', DepartamentoController::class);
Route::resource('provincias', ProvinciaController::class);
Route::resource('municipios', MunicipioController::class);
Route::resource('localidades', LocalidadController::class);
Route::resource('recintos', RecintoController::class);
Route::resource('mesas', MesaController::class);

// Gestión Electoral
Route::resource('candidatos', CandidatoController::class);
Route::resource('resultados', ResultadoController::class);

// Rutas adicionales para resultados
Route::get('resultados/mesa/{mesa}/edit', [ResultadoController::class, 'edit'])->name('resultados.mesa.edit');
Route::put('resultados/mesa/{mesa}', [ResultadoController::class, 'update'])->name('resultados.mesa.update');
Route::post('resultados/{resultado}/estado-acta', [ResultadoController::class, 'updateEstadoActa'])->name('resultados.estado-acta');
Route::get('actas/{id}/detalles', [ResultadoController::class, 'detallesActa'])->name('actas.detalles');
Route::post('actas/{id}/aprobar', [ResultadoController::class, 'aprobarActa'])->name('actas.aprobar');
Route::post('actas/{id}/revisar', [ResultadoController::class, 'revisarActa'])->name('actas.revisar');

// API para filtros
Route::get('api/provincias-por-departamento/{departamentoId}', [ProvinciaController::class, 'getByDepartamento']);
Route::get('api/municipios-por-provincia/{provinciaId}', [MunicipioController::class, 'getByProvincia']);
Route::get('api/localidades-por-municipio/{municipioId}', [LocalidadController::class, 'getByMunicipio']);
Route::get('api/recintos-por-localidad/{localidadId}', [RecintoController::class, 'getByLocalidad']);
Route::get('api/mesas-por-recinto/{recintoId}', [MesaController::class, 'getByRecinto']);

});
