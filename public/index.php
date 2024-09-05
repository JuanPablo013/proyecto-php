<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\InstructoresController;
use Controllers\EventosController;
use Controllers\RegistradosController;
use Controllers\RegalosController;
use Controllers\PaginasController;
use Controllers\RegistroController;
use Controllers\APIEventos;
use Controllers\APIInstructores;
use Controllers\APIRegalos;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

// Area de administración
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/instructores', [InstructoresController::class, 'index']);
$router->get('/admin/instructores/crear', [InstructoresController::class, 'crear']);
$router->post('/admin/instructores/crear', [InstructoresController::class, 'crear']);
$router->get('/admin/instructores/editar', [InstructoresController::class, 'editar']);
$router->post('/admin/instructores/editar', [InstructoresController::class, 'editar']);
$router->post('/admin/instructores/eliminar', [InstructoresController::class, 'eliminar']);

$router->get('/admin/eventos', [EventosController::class, 'index']);
$router->get('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->post('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->get('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/eliminar', [EventosController::class, 'eliminar']);

$router->get('/api/eventos-horario', [APIEventos::class, 'index']);
$router->get('/api/instructores', [APIInstructores::class, 'index']);
$router->get('/api/instructor', [APIInstructores::class, 'instructor']);
$router->get('/api/regalos', [APIRegalos::class, 'index']);

$router->get('/admin/registrados', [RegistradosController::class, 'index']);

$router->get('/admin/regalos', [RegalosController::class, 'index']);

// Registro de usuarios
$router->get('/finalizar-registro', [RegistroController::class, 'crear']);
$router->post('/finalizar-registro/gratis', [RegistroController::class, 'gratis']);
$router->post('/finalizar-registro/pagar', [RegistroController::class, 'pagar']);
$router->get('/finalizar-registro/conferencias', [RegistroController::class, 'conferencias']);
$router->post('/finalizar-registro/conferencias', [RegistroController::class, 'conferencias']);

// Boleto virtual
$router->get('/boleto', [RegistroController::class, 'boleto']);

// Área pública
$router->get('/', [PaginasController::class, 'index']);
$router->get('/proyecto', [PaginasController::class, 'evento']);
$router->get('/paquetes', [PaginasController::class, 'paquetes']);
$router->get('/conferencias-workshops', [PaginasController::class, 'conferencias']);
$router->get('/404', [PaginasController::class, 'error']);

$router->comprobarRutas();