/***************************************************************
 *  Copyright notice
 *
 *  (c) Nirmalya Mondal (http://typo3nirmalya.blogspot.in/)
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

"use strict";

/**
 * @var object
 */
var map;

/**
 * @var Object
 */
var geocoder;

/**
 * @var object
 */
var directionsService;

/**
 * @var object
 */
var directionsDisplay;

/**
 * @var object
 */
var listContainer = document.getElementById('route-suggest-list');

/**
 * @var object
 */
var $routeStart;
$routeStart = $('input#route-source');

/**
 * @var object
 */
var $routeSuggestList;
$routeSuggestList = $('#route-suggest-list');

/**
 * Initialize the Google Map on Window load event
 */
$(window).load(function () {
    googleMapInit();
});

/**
 * Route show functionality is binded with focusout event for Starting point
 */
$routeStart.focusout(function () {
    calcRoute();
});

/**
 * Showing the dropdown list of places on keyup event for Starting point
 */
$routeStart.keyup(function () {
    geocode();
});

/**
 * Showing the Map on change event with Starting point
 */
$routeStart.change(function () {
    mapFirst();
});

/**
 * Route Start point selection is binded with on focus event 
 */
$routeStart.focus(function () {
    this.select();
});

/**
 * Route show functionality is binded with on change event 
 */
$('select#route-destination').change(function () {
    calcRoute();
});

/**
 * Initializes the Google Map with latitude and longitde to India.
 *
 * @return {void}
 */
function googleMapInit() {
    map = new google.maps.Map(document.getElementById('googlemap'), {
        center: new google.maps.LatLng(21.000000, 78.000000),
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scaleControl: true,
        scrollwheel: false
    });
    geocoder = new google.maps.Geocoder;
    var infoWindow = new google.maps.InfoWindow;

    geocodeLatLng(geocoder, map, infoWindow);

    directionsService = new google.maps.DirectionsService();
    directionsDisplay = new google.maps.DirectionsRenderer();
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('route-directions-panel'));
    geocoder.firstItem = {};
}

/**
 * Try to grab current position of the user and set this as default start location.
 *
 * @return {void}
 */
function geocodeLatLng(geocoder, map, infowindow) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
            geocoder.geocode({'location': latlng}, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        map.setZoom(11);
                        var marker = new google.maps.Marker({
                            position: latlng,
                            map: map
                        });
                        var formattedAddress = results[1].formatted_address;
                        infowindow.setContent(formattedAddress);
                        infowindow.open(map, marker);
                        $routeStart.val(formattedAddress);
                        calcRoute();
                    } else {
                        window.alert('No Address found');
                    }
                } else {
                    window.alert('Geocoder failed to fetch address due to: ' + status);
                }
            });
        });
    } else {
        handleLocationError(false, infowindow, map.getCenter());
    }

}

/**
 * Throws error when geolocation detection is failed.
 *
 * @return {void}
 */
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}

/**
 * Show the route plan on Google Map based on source and destination.
 *
 * @return {void}
 */
function calcRoute() {
    var $routeDestinationSelected;
    $routeDestinationSelected = $('#route-destination').find('option:selected');
    var selectedId = $routeDestinationSelected.val();
    if (selectedId == 0) return false;
    var start = $routeStart.val();
    var end = $routeDestinationSelected.text();
    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}

/**
 * Generate and show list of places in a dropdown manner based on the input value from user.
 *
 * @return {void}
 */
function geocode() {
    var query = $routeStart.val();
    if (query && query.trim) query = query.trim(); // trim space if browser supports
    if (query != geocoder.resultAddress && query.length > 1) { // no useless request
        clearTimeout(geocoder.waitingDelay);
        geocoder.waitingDelay = setTimeout(function () {
            geocoder.geocode({address: query}, geocodeResult);
        }, 300);
    } else {
        $routeSuggestList.html('');
        geocoder.resultAddress = '';
        geocoder.resultBounds = null;
    }
    // callback function
    function geocodeResult(response, status) {
        if (status == google.maps.GeocoderStatus.OK && response[0]) {
            geocoder.firstItem = response[0];
            clearListItems();
            var len = response.length;
            for (var i = 0; i < len; i++) {
                $routeSuggestList.show();
                addListItem(response[i]);
            }
        } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
            $routeSuggestList.html(' ');
            geocoder.resultAddress = '';
            geocoder.resultBounds = null;
        } else {
            $routeSuggestList.html(status);
            geocoder.resultAddress = '';
            geocoder.resultBounds = null;
        }
    }
}

/**
 * Show the route map when destination point change from option select.
 *
 * @return {void}
 */
function mapFirst() {
    geocoder.firstItem.geometry && geocoder.firstItem.geometry.viewport
    && map.fitBounds(geocoder.firstItem.geometry.viewport);
    $routeStart.val(geocoder.firstItem.formatted_address);
    setTimeout(function () {
        clearListItems()
    }, 1000);
}

/**
 * Generate dropdown list of places based on response.
 *
 * @return {void}
 */
function addListItem(resp) {
    var loc = resp || {};
    var row = document.createElement('li');
    row.innerHTML = loc.formatted_address;
    row.className = 'list-item';
    row.onclick = function () {
        calcRoute();
    };
    listContainer.appendChild(row);
}

/**
 * Hide and Remove dropdown list of places.
 *
 * @return {void}
 */
function clearListItems() {
    $routeSuggestList.hide();
    while (listContainer.firstChild) {
        listContainer.removeChild(listContainer.firstChild);
    }
}
