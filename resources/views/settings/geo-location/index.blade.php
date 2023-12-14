@extends('layouts.settings-layout')
@section('content')
    <!-- Start::row-1 -->
    <div class="row">
        <div class="erp-add-employee-wrapper mb-3">
            <div class="erp-add-employee">
                <a href="javascript:void(0)" class="btn add-btn erp-add-employee" onclick="openCreateLocationModal()">
                    <i class="fa-solid fa-plus"></i> Add Location
                </a>
            </div>
        </div>
        <div class="erp-employee-list-wrapper">
            <div class="erp-main-filter-wrapper bg-card attd-table">
                <div class="my-attendance-box-item flex-100 ">
                    <div class="my-attendance-report-wrapper">
                        <div class="erp-header-main-wrap d-flex justify-content-between align-items-center">
                            <div class="erp-box-header">
                                <h4>Geo Location Setting </h4>
                            </div>

                        </div>

                        <div class="big-table pt-4">
                            <div class="de-table-wrapper" id="ajax-data-load">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->
@endsection

@section('modals')
    @include('settings.geo-location._add_geo_location_modal')
    @include('settings.geo-location._edit_geo_location_modal')
@endsection

@section('css')

@endsection

@section('css_plugins')

@endsection

@section('js_plugins')

@endsection

@section('js')
    <!-- Google Map Api -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAw74VNUecFrAFANUq9WnHIKPVAPsCqyZg&libraries=drawing,places&v=weekly&callback=initialize" defer>
    </script>
    <script>
        $(document).ready(function(){
            getData();
            initialize();
            $("#geoLocationStoreForm").on('submit', function (e) {
                var self = this;
                e.preventDefault();
                var formData = new FormData($(self)[0]);
                $(".ie-span").text("").hide();
                var url = $(self).attr('action');

                formPost(url, formData, function (res) {
                    $("#add_geo_location_modal").modal('hide');
                    $(self)[0].reset();
                    showSuccessAlert('Success',res.message)
                    getData();
                }, 'show_input_error');
            });

            $(document).on("submit", "#geoLocationFormEdit", function(e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $(".ie-span").text("").hide();
                var url = $(this).attr('action');

                formPost(url, formData, function (res){
                    $("#edit_geo_location_modal").modal('hide');
                    showSuccessAlert('Success',res.message)
                    getData();
                }, 'show_input_error');
            });

        });

        function getData(){
            getPaginatedListData("{{ route('settings.geo-location.filtered') }}", "#ajax-data-load");
        }

        function getPaginatedData(button) {
            getPaginatedListData($(button).attr('data-href'), "#ajax-data-load");
        }



        function editItem(id){
            let url = "{{route('settings.geo-location.edit', ':id')}}";
            url = url.replace(':id', id);
            ajaxGet(url, {}, function (response) {
                if (response.status == 200) {
                    $("#edit_geo_location_modal_body").html(response.view);
                    $("#edit_geo_location_modal").modal('show');
                    openCreateLocationModal();
                } else {
                    toastr.error(response.message);
                }
            }, 'default');
        }


    </script>

    <script>

        function openCreateLocationModal() {
            $("#add_geo_location_modal").modal('show');
            initMap('map', 23.7452295, 90.3521059, '#map_json_data_create');
        }

        function setDeleteData(id)
        {
            $("#delete_location .location_id").val(id)
            ;
        }
        function IsJsonString(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
    </script>

    <script>
        var drawingManager;
        var selectedShape;
        var map;
        function deleteSelectedShape(data_place_element) {
            if (selectedShape != null) {
                selectedShape.setMap(null);
                // To show:
                drawingManager.setOptions({
                    drawingControl: true,
                    drawingMode: google.maps.drawing.OverlayType.POLYGON,
                });
            }
            $(data_place_element).val("");
        }
        function initMap(element_id, center_point_lat, center_point_lng, data_place_element, triangleCoords=null) {
            map = new google.maps.Map(document.getElementById(element_id), {
                center: { lat: center_point_lat, lng: center_point_lng },
                zoom: 14,
            });

            /*new google.maps.Marker({
                position: { lat: center_point_lat, lng: center_point_lng },
                map
            });*/

            if (triangleCoords !== null) {
                if (IsJsonString(triangleCoords)) {
                    triangleCoords = JSON.parse(triangleCoords);

                    // Construct the polygon.
                    const bermudaTriangle = new google.maps.Polygon({
                        paths: triangleCoords,
                        strokeColor: "#3f25ff",
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        fillColor: "#3f25ff",
                        fillOpacity: 0.35,
                    });
                    bermudaTriangle.setMap(map);
                    selectedShape = bermudaTriangle;
                }
            }

            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [
                        google.maps.drawing.OverlayType.POLYGON,
                    ],
                },
                polygonOptions: {
                    clickable: false,
                    editable:  false,
                    strokeColor: '#3f25ff',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#3F25FF',
                    fillOpacity: 0.35,
                },
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, 'polygoncomplete', function(overlay) {
                selectedShape = overlay;
                drawingManager.setDrawingMode(null);
                drawingManager.setOptions({
                    drawingControl: false,
                });
                var lat_key = Object.keys(overlay.latLngs)[0];

                var total_json_data = [];
                // let contents = overlay.latLngs.Mb[0].Mb;
                var contents = [];
                if (overlay.latLngs[lat_key] != undefined) {
                    contents = overlay.latLngs[lat_key][0][lat_key];
                } else {
                    contents = overlay.latLngs.Lb[0].Lb;
                }
                for (i=0; i<contents.length; i++) {
                    var new_data = {
                        lat : contents[i].lat(),
                        lng : contents[i].lng()
                    };
                    total_json_data.push(new_data);
                }
                $(data_place_element).val(JSON.stringify(total_json_data));

            });
        }

    </script>

    <script>
        $(document).ready(function() {
            /*$("#lat_area").addClass("d-none");
            $("#long_area").addClass("d-none");*/
        });
    </script>
    <script>
        // google.maps.event.addDomListener(window, 'load', initialize);
        let autocomplete;
        var marker;
        function initialize() {
            // var input = document.getElementById('autocomplete');
            autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'),
                {
                    types:['establishment'],
                    fields: ['place_id', 'geometry', 'name']
                }
            );

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();

                map.setCenter({
                    lat : place.geometry['location'].lat(),
                    lng : place.geometry['location'].lng()
                });
            });
        }
    </script>
@endsection


