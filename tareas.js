const lista_categorias = document.querySelector('#lista_categorias');
const lista_tareas = document.querySelector('#lista_tareas');

lista_categorias.onchange = pideTareasPorCategoria ;

function pideCategorias()  {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()   {
        if( this.readyState == 4 && this.status == 200 )    {
            insertaCategorias( this );        
        }
    }

    xhttp.open('GET', 'http://localhost/ejercicios-php/conexion_tareas.php?categorias=SI', true );/* No importa el valor de categorias */
    xhttp.send();
}

function insertaCategorias( xhttp ) {
    var categorias = JSON.parse( xhttp.responseText );
    categorias.forEach( function( item ) {
        lista_categorias.innerHTML += `<option value="${item[0]}">${item[1]}</option>` ;
    });
}

function pideTareasPorCategoria()    {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()   {
        if( this.readyState == 4 && this.status == 200 )    {
            muestraTareasDeCategoria( this );        
        }
    }

    xhttp.open('GET', 'http://localhost/ejercicios-php/conexion_tareas.php?categoria=' + this.value );
    xhttp.send();
}

function muestraTareasDeCategoria( xhttp )    {
    lista_tareas.innerHTML = '' ;

    var tareas = JSON.parse( xhttp.responseText );
    
    tareas.forEach( function( item )    {
        var contenedor_tarea = document.createElement('div');
        contenedor_tarea.className = 'flex-column bt bb m-0';

        var info = document.createElement('div');
        info.className = `text-right top-tarea-info`;
        info.innerText = `Categoría ${item._categoria_id}`;

        if( item._fecha_limite != null )    {
            info.innerText += `- ${item._fecha_limite}`;
        }

        var titulo = document.createElement('h2');
        titulo.className = `text-left m-0`;
        titulo.innerText = `${item._titulo}`;
        
        var texto = document.createElement('div');
        texto.className = `text-left m-1`;
        texto.innerText = `${item._descripcion}`;

        contenedor_tarea.appendChild( info );
        contenedor_tarea.appendChild( titulo );
        contenedor_tarea.appendChild( texto );

        lista_tareas.appendChild( contenedor_tarea );
    });
}

/* Al cargar */
pideCategorias();
lista_categorias.onchange();