<?php
    include_once __DIR__ . '/conferencias.php';
?>

<section class="resumen">
    <div class="resumen__grid">
        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $instructores_total; ?></p>
            <p class="resumen__texto">Instructores</p>
        </div>

        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $conferencias_total; ?></p>
            <p class="resumen__texto">Conferencias</p>
        </div>

        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero"><?php echo $workshops_total; ?></p>
            <p class="resumen__texto">Workshops</p>
        </div>

        <div <?php aos_animacion(); ?> class="resumen__bloque">
            <p class="resumen__texto resumen__texto--numero">500</p>
            <p class="resumen__texto">Asistentes</p>
        </div>
    </div>
</section>

<section class="instructors">
    <h2 class="instructors__heading">Instructores</h2>
    <p class="instructors__descripcion">Conoce a los expertos de Proyecto PHP</p>

    <div class="instructors__grid">
        <?php foreach($instructores as $instructor) { ?>
            <div <?php aos_animacion(); ?> class="instructor">
                <picture>
                    <source srcset="img/instructors/<?php echo $instructor->imagen; ?>.webp" type="image/webp">
                    <source srcset="img/instructors/<?php echo $instructor->imagen; ?>.png" type="image/png">
                    <img class="instructor__imagen" loading="lazy" width="200" height="300" src="img/instructors/<?php echo $instructor->imagen; ?>.png" alt="Imagen instructor">
                </picture>

                <div class="instructor__informacion">
                    <h4 class="instructor__nombre">
                        <?php echo $instructor->nombre . ' ' . $instructor->apellido; ?>
                    </h4>

                    <p class="instructor__ubicacion">
                        <?php echo $instructor->ciudad . ', ' . $instructor->pais; ?>
                    </p>

                    <nav class="instructor-sociales">
                        <?php
                            $redes = json_decode( $instructor->redes );
                        ?>
                        
                        <?php if(!empty($redes->facebook)) { ?>
                            <a class="instructor-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->facebook; ?>">
                                <span class="instructor-sociales__ocultar">Facebook</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($redes->x)) { ?>
                            <a class="instructor-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->x; ?>">
                                <span class="instructor-sociales__ocultar">X</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->youtube)) { ?>
                            <a class="instructor-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->youtube; ?>">
                                <span class="instructor-sociales__ocultar">YouTube</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->instagram)) { ?>
                            <a class="instructor-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->instagram; ?>">
                                <span class="instructor-sociales__ocultar">Instagram</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->tiktok)) { ?>
                            <a class="instructor-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->tiktok; ?>">
                                <span class="instructor-sociales__ocultar">Tiktok</span>
                            </a> 
                        <?php } ?> 

                        <?php if(!empty($redes->github)) { ?>
                            <a class="instructor-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->github; ?>">
                                <span class="instructor-sociales__ocultar">Github</span>
                            </a>
                        <?php } ?> 
                    </nav>

                    <ul class="instructor__listado-skills">
                        <?php 
                            $tags = explode(',', $instructor->tags);
                            foreach($tags as $tag) { 
                        ?>
                            <li class="instructor__skill"><?php echo $tag; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<div id="mapa" class="mapa"></div>

<section class="boletos">
    <h2 class="boletos__heading">Boletos & Precios</h2>
    <p class="boletos__descripcion">Precios para Proyecto PHP</p>

    <div class="boletos__grid">
        <div class="boleto boleto--presencial">
            <h4 class="boleto__logo">&#60;Proyecto PHP /></h4>
            <p class="boleto__plan">Presencial</p>
            <p class="boleto__precio">$199</p>
        </div>

        <div class="boleto boleto--virtual">
            <h4 class="boleto__logo">&#60;Proyecto PHP /></h4>
            <p class="boleto__plan">Virtual</p>
            <p class="boleto__precio">$49</p>
        </div>

        <div class="boleto boleto--gratis">
            <h4 class="boleto__logo">&#60;Proyecto PHP/></h4>
            <p class="boleto__plan">Gratis</p>
            <p class="boleto__precio">Gratis - $0</p>
        </div>
    </div>

    <div class="boleto__enlace-contenedor">
        <a href="/paquetes" class="boleto__enlace">Ver paquetes</a>
    </div>
</section>