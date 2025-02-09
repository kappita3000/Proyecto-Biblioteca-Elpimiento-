@extends('layouts.aa')

@section('content')

<div style="background: transparent; padding: 20px;">
    
    <div class="container">

<!-- Sección de últimos libros -->
        <!-- Carrousel de los últimos 5 libros agregados -->
        <h4 class="titulo-carrusel">Últimos Libros</h4>
        <div id="latestBooksCarousel" class="carousel slide mb-5" data-bs-ride="carousel"
            style="width: 100%; max-width: 100%; overflow: hidden; ">
            <div class="carousel-inner">
                @php
                    $ultimosLibros = \App\Models\Libro::latest()->with('autor', 'genero')->take(5)->get();
                @endphp
                @foreach ($ultimosLibros as $index => $libro)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="w-100 d-flex justify-content-center align-items-center"
                            style="height: 500px; background: transparent; ">
                            <div class="text-center" style="width: 100%; max-width: 300px;">
                                <a href="{{ route('libros.show', $libro->id) }} ">
                                    <h3 class="titulo-libro-carrusel">{{ $libro->titulo }}</h3>
                                </a>
                                @if ($libro->caratula && file_exists(public_path($libro->caratula)))
                                    <!-- Mostrar la imagen usando la ruta almacenada en la base de datos -->
                                    <img class="book-cover img-fluid rounded shadow" src="{{ asset($libro->caratula) }}"
                                        alt="Portada de {{ $libro->titulo }}">
                                @else
                                    <img src="{{ asset('img/placeholder.png') }}" alt="Portada no disponible">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#latestBooksCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#latestBooksCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <script>
            var myCarousel = document.querySelector('#latestBooksCarousel');
            var carousel = new bootstrap.Carousel(myCarousel, {
                interval: 4000,
                ride: 'carousel'
            });
        </script>
<!-- Fin de la sección de últimos libros -->

<!-- Sección de categorías -->
<!-- Sección de categorías -->
<div class="categories-section">
    <h2 style="text-align: center; margin-bottom: 20px;">Categorías</h2>
    <div style="display: grid; height: 800px !important; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
        @foreach($categorias as $categoria)
        <div style="background-color: white; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center;">
            <h3 style="display: center; padding-top: 30px;">{{ $categoria->nombre }}</h3>
            <p>{{ $categoria->descripcion }}</p>
            <a href="{{ route('filtrarPorCategoria', ['category' => $categoria->id]) }}"
               style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; font-size: 0.9rem; transition: background-color 0.3s;">
                Ver libros
            </a>
        </div>
        @endforeach
    </div>
</div>
<!-- Fin de la sección de categorías -->




        <!-- Sección del mapa -->
        <div class="map-section">
            <div class="map-container" id="map"></div>
            <div class="map-text">
                <p>Nos encontramos en la plaza de el pimiento, este espacio publico esta abierto para todas las personas desde el dia lunes a viernes a partir de las 2PM hasta las 5PM, te esperamos con la mejor disposicion </p>
            </div>
        </div>
    </div>
</div>

<div class="container2">
   <!-- Sección "Sobre nosotros" -->
   <div class="about-section">
        <h2>Sobre nosotros</h2>
        <div class="about-cards">
            <div class="card">
                <h3>Quiénes somos</h3>
                <p>Somos un espacio comunitario donde las personas pueden leer, buscar información y estudiar. Nuestro único objetivo es garantizar oportunidades de acceso a la información, fomentando la lectura y el uso de servicios virtuales. Aunque estamos en una zona rural, no estamos ajenos al desarrollo, la cultura y la recreación.</p>
            </div>
            <div class="card">
                <h3>Misión</h3>
                <p>Nuestra misión es facilitar el acceso a la información como un eje central para promover la lectura y el uso de nuevas tecnologías. Buscamos ser un centro cultural que contribuye a la integración social y a la preservación de la herencia cultural, satisfaciendo las necesidades de usuarios de todas las edades mediante servicios bibliotecarios eficientes y de calidad.</p>
            </div>
            <div class="card">
                <h3>Visión</h3>
                <p>Nuestra visión es convertirnos en un referente de información y cultura para nuestra comunidad y sus usuarios, ofreciendo un espacio moderno y accesible. Aspiramos a fomentar la creatividad y el uso del tiempo libre, contribuyendo al desarrollo personal y comunitario.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfe4LVLV1Ah3E6avo8JHFo92kIjDjUKdY" async defer></script>
<script>



    function initMap() {
        const ubicacion = { lat: -33.57346760204582, lng: -70.98180886814293 }; // Coordenadas de tu ubicación

        // Crear el mapa
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 19,
            center: ubicacion,
        });

        // Crear el marcador con una imagen personalizada y un tamaño específico
        const marker = new google.maps.Marker({
            position: ubicacion,
            map: map,
            title: "Aquí estamos",
            icon: {
                url: "https://img.icons8.com/?size=100&id=ChugQlss1ohB&format=png&color=000000",
                size: new google.maps.Size(40, 40),  // Tamaño del marcador (ancho, alto)
                scaledSize: new google.maps.Size(40, 40), // Escala el tamaño si es necesario
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(20, 40) // Cambiar según el punto de anclaje
            }
        });

        // Crear el infowindow con el mensaje
        const infowindow = new google.maps.InfoWindow({
            content: "Aquí estamos", // Mensaje que quieres mostrar
        });

        // Mostrar el infowindow al cargar la página
        infowindow.open(map, marker);
    }

    // Inicializar el mapa al cargar la página
    window.onload = initMap;
</script>
@endsection
