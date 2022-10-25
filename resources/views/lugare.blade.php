@extends('layout.master')
@section('titulo', $lugare->nombre)
@section('cabecera')
    <section class="inner-banner-wrap">
        <div class="inner-baner-container" style="background-image: url({{  Voyager::image($lugare->foto) }});">
            <div class="container">
                <div class="inner-banner-content">
                    <h1 class="inner-title">{{ $lugare->nombre }}</h1>
                </div>
            </div>
        </div>
        <div class="inner-shape"></div>
    </section>
@endsection
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        .leaflet-container {
            height: 400px;
            width: 600px;
            max-width: 100%;
            max-height: 100%;
        }
    </style>
@endpush
@section('contenido')
    <!-- product section html start -->
    <div class="product-outer-wrap product-wrap">
        <div class="product-inner-wrap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="product-thumbnails">
                            <div class="single-product-item">
                                <figure class="feature-image">
                                    <img src="{{  Voyager::image($lugare->foto) }}" alt="{{ $lugare->nombre }}">
                                </figure>
                                <div class="image-search-icon">
                                    <a href="{{  Voyager::image($lugare->foto) }}" data-lightbox="lightbox-set">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </div>
                            </div>
                           @php
                                $galeria = json_decode($sitio->galeria);
                            @endphp
                            @if(!is_null($galeria))
                                @foreach($galeria as $imagen)
                                    <div class="single-product-item">
                                        <figure class="feature-image">
                                            <img src="{{ Voyager::image($imagen) }}" alt="">
                                        </figure>
                                        <div class="image-search-icon">
                                            <a href="{{ Voyager::image($imagen) }}" data-lightbox="lightbox-set">
                                                <i class="fas fa-search"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="product-thumb-nav">
                            <div class="single-product-item">
                                <figure class="feature-image">
                                    <img src="{{  Voyager::image($lugare->foto) }}" alt="">
                                </figure>
                            </div>
                            @if(!is_null($galeria))
                                @foreach($galeria as $imagen)
                                    <div class="single-product-item">
                                        <figure class="feature-image">
                                            <img src="{{ Voyager::image($imagen) }}" alt="">
                                        </figure>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="product-summary">

                            <h2>{{ $lugare->nombre }}</h2>
                            <div class="product-price">
                                <ins>{{ ($lugare->costo == 0) ? 'GRATIS' : '$'.$lugare->costo }}</ins>
                            </div>
                            <div class="product-meta">
                                <div class="cat-detail">
                                    <strong>Categorias:</strong>
                                    @foreach($lugare->categorias as $categoria)
                                        <a href="{{ route('categoria', $categoria) }}">{{ $categoria->nombre }}</a>
                                        @if(!$loop->last)
                                            /
                                        @endif
                                    @endforeach

                                </div>
                                <div class="tag-detail">
                                    <strong>Otros nombres:</strong>
                                    {{ $lugare->otrosnombre }}
                                </div>
                            </div>
                            <div class="product-desc">
                                <p>{!! explode('<p>', $lugare->descripcion)[1] !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-tab-outer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tab-container">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Descripción</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ecosistema-tab" data-toggle="tab" href="#ecosistema" role="tab" aria-controls="review" aria-selected="false">Ecosistema</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Eventos</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                    <div class="overview-content">
                                        {!! $lugare->descripcion !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" aling="center">
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
    <script>
        var map = L.map('map').setView([{{ $lugare->getCoordinates()[0]['lng'] }}, {{ $lugare->getCoordinates()[0]['lat'] }}], 13);
        var marker = L.marker([{{ $lugare->getCoordinates()[0]['lng'] }}, {{ $lugare->getCoordinates()[0]['lat'] }}]).addTo(map);
        marker.bindPopup("{{ $lugare->nombre }} / {{ $lugare->otrosnombre }}").openPopup();
        var tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(map);
    </script>
@endsection

