<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/instructores/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Intructor
    </a>
</div>

<div class="dashboard__contenedor">
    <?php if(!empty($instructores)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Ubicación</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($instructores as $instructor) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $instructor->nombre . " " . $instructor->apellido; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $instructor->ciudad . ", " . $instructor->pais; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/instructores/editar?id=<?php echo $instructor->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>

                            <form method="POST" action="/admin/instructores/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $instructor->id; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay instructores aún</p>
    <?php } ?>
</div>

<?php 
    echo $paginacion;
?>

