(function() {
    const instructoresInput = document.querySelector('#instructores');

    if(instructoresInput) {
        let instructores = [];
        let instructoresFiltrados = [];

        const listadoInstructores = document.querySelector('#listado-instructores')
        const instructorHidden = document.querySelector('[name="instructor_id"]')

        obtenerInstructores();
        instructoresInput.addEventListener('input', buscarInstructores)

        if(instructorHidden.value) {
            (async() => {
                const instructor = await obtenerInstructor(instructorHidden.value)
                const {nombre, apellido} = instructor

                // Insertar en el HTML
                const instructorDOM = document.createElement('LI');
                instructorDOM.classList.add('listado-instructores__instructor', 'listado-instructores__instructor--seleccionado');
                instructorDOM.textContent = `${nombre} ${apellido}`

                listadoInstructores.appendChild(instructorDOM)
            })()
        }

        async function obtenerInstructores() {
            const url = `/api/instructores`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            formatearInstructores(resultado)
        }

        async function obtenerInstructor(id) {
            const url = `/api/instructor?id=${id}`;
            const respuesta = await fetch(url)
            const resultado = await respuesta.json()
            return resultado;
        }

        function formatearInstructores(arrayInstructores = []) {
            instructores = arrayInstructores.map( instructor => {
                return {
                    nombre: `${instructor.nombre.trim()} ${instructor.apellido.trim()}`,
                    id: instructor.id
                } 
            })
        }

        function buscarInstructores(e) {
            const busqueda = e.target.value;

            if(busqueda.length >= 3) {
                const expresion = new RegExp(busqueda.normalize('NFD').replace(/[\u0300-\u036f]/g, ""), "i");
                instructoresFiltrados = instructores.filter(ponente => {
                    if(ponente.nombre.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase().search(expresion) != -1) {
                        return ponente
                    }
                })
            } else {
                instructoresFiltrados = []
            }

            mostrarInstructores();
        }

        function mostrarInstructores() {

            while(listadoInstructores.firstChild) {
                listadoInstructores.removeChild(listadoInstructores.firstChild)
            }

            if(instructoresFiltrados.length > 0) {
                instructoresFiltrados.forEach(instructor => {
                    const instructorHTML = document.createElement('LI');
                    instructorHTML.classList.add('listado-instructores__instructor')
                    instructorHTML.textContent = instructor.nombre;
                    instructorHTML.dataset.instructorId = instructor.id
                    instructorHTML.onclick = seleccionarInstructor

                    // Añadir al dom
                    listadoInstructores.appendChild(instructorHTML)
                })
            } else {
                const noResultados = document.createElement('P')
                noResultados.classList.add('listado-instructores__no-resultado')
                noResultados.textContent = 'No hay resultados para tu búsqueda'
                listadoInstructores.appendChild(noResultados)              
            }
        }

        function seleccionarInstructor(e) {
            const instructor = e.target;

            // Remover la clase previa
            const instructorPrevio = document.querySelector('.listado-instructores__instructor--seleccionado')
            if(instructorPrevio) {
                instructorPrevio.classList.remove('listado-instructores__instructor--seleccionado')
            }
            instructor.classList.add('listado-instructores__instructor--seleccionado')

            instructorHidden.value = instructor.dataset.instructorId
        }
    }

})();

    