@extends('front.layouts.master')

@section('page_title', s_trans('Əlaqə').' - Amerikan Aptek')
@section('meta_tags', $translations[$page_meta->meta_tags])
@section('meta_desc', $translations[$page_meta->meta_desc])

@push('css')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGIJ_1dEU3NTyEJJeUQ5UZhn56pL0W0M4"></script>
@endpush

@section('main')

@include('front.includes.breadcrumb', ['title'=>s_trans('Əlaqə')])

<section class="inno-last container-fluid px-0">
    <div class="container">
        <div class="row g-3">
            <div class="col-12">
                <div class="aptek-addresses py-2">
                    <div class="bg-section p-0">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 col-xl-4">
                                <div class="address-panel p-4">
                                    <ul class="nav nav-pills mb-4" id="addressTab" role="tablist">
                                        @foreach(['Baku'] as $k=>$city)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if($k==0) active @endif" id="btn-city-{{ strtolower($city) }}" 
                                                    data-bs-toggle="tab" data-bs-target="#city-{{ strtolower($city) }}" 
                                                    type="button" role="tab" aria-controls="city-{{ strtolower($city) }}" 
                                                    aria-selected="true">{{ s_trans($city) }}</button>
                                        </li>
                                        @endforeach                
                                    </ul>
                                    <div class="tab-content w-100" id="addressTabContent">
                                        @php
                                            $map_pins = [];
                                        @endphp
                                        @foreach(['Baku'] as $k=>$city)
                                        <div class="tab-pane fade @if($k==0) show active @endif" 
                                                id="city-{{ strtolower($city) }}" role="tabpanel" 
                                                aria-labelledby="btn-city-{{ strtolower($city) }}" tabindex="0">
                                            <ul class="branch-list">
                                                @foreach($branches as $branch)
                                                <li class="branch py-3">
                                                    <i class="address-icon bi bi-geo"></i>
                                                    <div>
                                                        <h6 class="mb-1">{{ $translations[$branch->name] }}</h6>
                                                        {!! $translations[$branch->address] !!}
                                                        <div style="font-size: 0.9rem;">
                                                            @isset($branch->mobile_phone)
                                                            <a class="branch-phone mt-2 d-block" href="tel:{{ $branch->mobile_phone }}">
                                                                <i class="bi bi-telephone me-1"></i>{{ $branch->mobile_phone }}</a>
                                                            @endisset
                                                            @isset($branch->work_hours)
                                                            <span class="branch-hours d-block mt-2">
                                                                <i class="bi bi-clock me-1"></i>{{ $branch->work_hours }}
                                                            </span>
                                                            @endisset
                                                        </div>
                                                    </div>
                                                    <a href="tel:{{ $branch->mobile_phone }}" class="btn btn-call">
                                                        <i class="bi bi-telephone-fill"></i>
                                                    </a>
                                                </li>
                                                    @php
                                                    $map_pins[] = [
                                                        'name' => $translations[$branch->name],
                                                        'address' => $branch->coordinates,
                                                        'work_hours' => $branch->work_hours,
                                                        'phone' => $branch->mobile_phone,
                                                    ];
                                                    @endphp

                                                @endforeach
                                            </ul>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-7 col-xl-8">
                                    
                                    <div id="map" style="height: 400px;"></div>
                                    
                                    <script>
                                        // Initialize the map and set its view to the chosen geographic coordinates and zoom level
                                        var coordinates = @json($map_pins);
                                        
                                        function initMap() {
                                            // Center the map at some default location (this can be adjusted)
                                            var centerlatlang = coordinates[0].address.split(',');
                                            var centerCoordinates = { lat: parseFloat(centerlatlang[0].trim()), lng: parseFloat(centerlatlang[1].trim()) };
                                            var map = new google.maps.Map(document.getElementById('map'), {
                                                zoom: 13,
                                                center: centerCoordinates,
                                            });
                                            const bounds = new google.maps.LatLngBounds();
                                            const markers = [];
                                            const infoContents = [];
                                            const branches = document.querySelectorAll('.branch');
                                            const infoWindow = new google.maps.InfoWindow();

                                            // Add markers to the map
                                            coordinates.forEach(function(coord) {
                                                var latlang = coord.address.split(',');
                                                var marker = new google.maps.Marker({
                                                    position: { lat: parseFloat(latlang[0].trim()), lng: parseFloat(latlang[1].trim()) },
                                                    map: map,
                                                    title: coord.name,
                                                    icon: {
                                                        url: '/front/img/hero_logo.png',
                                                        scaledSize: new google.maps.Size(32, 32)
                                                    }
                                                });

                                                bounds.extend(marker.getPosition());
                                                markers.push(marker);

                                                content = `
                                                        <p style="font-size: 1.2rem;"> ${coord.name} </p>
                                                        <p><i class="bi bi-clock"></i> ${coord.work_hours} </p>
                                                        <a href="tel:${coord.phone}"><i class="bi bi-telephone"></i> ${coord.phone} </a>
                                                        
                                                    `;

                                                infoContents.push(content);

                                            });

                                            map.fitBounds(bounds);

                                            markers.forEach(function(marker, index){
                                                marker.addListener('click', function() {
                                                    infoWindow.setContent(infoContents[index]);
                                                    infoWindow.open(map, marker);
                                                });
                                            });

                                            

                                            $(document).on('click', '.branch', function(){
                                                map.setCenter(markers[$(this).index()].getPosition());
                                                map.setZoom(15); // Zoom in

                                                // Show info window for the selected branch
                                                infoWindow.setContent(infoContents[$(this).index()]);
                                                infoWindow.open(map, markers[$(this).index()]);
                                            });
                                        }

                                        // Initialize the map after the window has loaded
                                        window.onload = initMap;
                                    </script>


                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection