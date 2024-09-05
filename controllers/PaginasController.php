<?php

namespace Controllers;

use MVC\Router;
use Model\Dia;
use Model\Hora;
use Model\Evento;
use Model\Instructor;
use Model\Categoria;

class PaginasController {
    public static function index(Router $router) {

        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateados = [];
        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->instructor = Instructor::find($evento->instructor_id);
            
            if($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_v'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_s'][] = $evento;
            }

            if($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_v'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_s'][] = $evento;
            }
        }

        // Obtener el total de cada bloque
        $instructores_total = Instructor::total();
        $conferencias_total = Evento::total('categoria_id', 1);
        $workshops_total = Evento::total('categoria_id', 2);

        // Obtener todos los ponentes
        $instructores = Instructor::all();

        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventos_formateados,
            'instructores_total' => $instructores_total,
            'conferencias_total' => $conferencias_total,
            'workshops_total' => $workshops_total,
            'instructores' => $instructores
        ]);
    }

    public static function evento(Router $router) {
        $router->render('paginas/proyecto', [
            'titulo' => 'Proyecto PHP'
        ]);
    }

    public static function paquetes(Router $router) {
        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes'
        ]);
    }

    public static function conferencias(Router $router) {

        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateados = [];
        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->instructor = Instructor::find($evento->instructor_id);
            
            if($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_v'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_s'][] = $evento;
            }

            if($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_v'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_s'][] = $evento;
            }
        }

        $router->render('paginas/conferencias-workshops', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateados
        ]);
    }

    public static function error(Router $router) {

        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada'
        ]);
    }

}