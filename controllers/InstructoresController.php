<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Instructor;
use Intervention\Image\ImageManagerStatic as Image;

class InstructoresController {

    public static function index(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/instructores?page=1');
        }

        $registros_por_pagina = 5;

        $total = Instructor::total();

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/ponentes?page=1');
        }

        $instructores = Instructor::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/instructores/index', [
            'titulo' => 'Instructores',
            'instructores' => $instructores,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router) {

        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        $instructor = new Instructor;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }

            if(!empty($_FILES['imagen']['tmp_name'])) {

                $carpeta_imagenes = '../public/img/instructors';

                // Crear la carpeta si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5( uniqid( rand(), true) );

                $_POST['imagen'] = $nombre_imagen;

            } 

            $_POST['redes'] = json_encode( $_POST['redes'], JSON_UNESCAPED_SLASHES ); 
            $instructor->sincronizar($_POST);

            // Validar
            $alertas = $instructor->validar();

            // Guardar el registro
            if(empty($alertas)) {

                // Guardar las imagenes
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png" );
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp" );

                // Guardar en la BD
                $resultado = $instructor->guardar();

                if($resultado) {
                    header('Location: /admin/instructores');
                }
            }

        }
        
        $router->render('admin/instructores/crear', [
            'titulo' => 'Registrar instructor',
            'alertas' => $alertas,
            'instructor' => $instructor,
            'redes' => json_decode($instructor->redes)
        ]);
    }

    public static function editar(Router $router) {
        if(!is_admin()) {
            header('Location: /login');
        }

        $alertas = [];
        
        // Validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id) {
            header('Location: /admin/instructores');
        }

        // Obtener instructor a editar
        $instructor = Instructor::find($id);

        if(!$instructor) {
            header('Location: /admin/instructores');
        }

        $instructor->imagen_actual = $instructor->imagen;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            if(!is_admin()) {
                header('Location: /login');
            }

            if(!empty($_FILES['imagen']['tmp_name'])) {
                
                $carpeta_imagenes = '../public/img/instructors';

                // Crear la carpeta si no existe
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5( uniqid( rand(), true) );

                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $instructor->imagen_actual;
            }

            $_POST['redes'] = json_encode( $_POST['redes'], JSON_UNESCAPED_SLASHES );     
            $instructor->sincronizar($_POST);

            $alertas = $instructor->validar();

            if(empty($alertas)) {
                if(isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png" );
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp" );
                }
                $resultado = $instructor->guardar();
                if($resultado) {
                    header('Location: /admin/instructores');
                }
            }

        }

        $router->render('admin/instructores/editar', [
            'titulo' => 'Editar instructor',
            'alertas' => $alertas,
            'instructor' => $instructor,
            'redes' => json_decode($instructor->redes)
        ]);
    }

    public static function eliminar() {
        if(!is_admin()) {
            header('Location: /login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_admin()) {
                header('Location: /login');
            }
            
            $id = $_POST['id'];
            $instructor = Instructor::find($id);
            if(!isset($instructor) ) {
                header('Location: /admin/instructores');
            }

            if ($instructor->imagen) {
                $carpeta_imagenes = '../public/img/instructors';
                unlink($carpeta_imagenes . '/' . $instructor->imagen . ".png");
                unlink($carpeta_imagenes . '/' . $instructor->imagen . ".webp");
            }

            $resultado = $instructor->eliminar();
            if($resultado) {
                header('Location: /admin/instructores');
            }
        }

    }

}