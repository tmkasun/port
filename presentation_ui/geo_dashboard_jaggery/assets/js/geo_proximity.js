/**
 * Created by kbsoft on 10/6/14.
 */
var centerLocation = new L.LatLng(6.999833130825296, 79.99855044297874);
var resizeIconLocation = new L.LatLng(6.99847, 80.14412);
var proximityMap = L.map("proximityMap", {
    zoom: 10,
    center: centerLocation,
    zoomControl: false,
    attributionControl: false,
    maxZoom: 20
    });
var proximityDistance = $("#proximityDistance");
L.grid({
    redraw: 'move'
    }).addTo(proximityMap);

//proximityMap.scrollWheelZoom.disable();

var marker = L.marker(centerLocation).setIcon(normalIcon);

marker.addTo(proximityMap);

var resizeIcon = L.icon({
    iconUrl: ApplicationOptions.leaflet.iconUrls.resizeIcon,
    iconAnchor: [24, 24]
    });

var resizeMarker = L.marker(resizeIconLocation, {icon: resizeIcon, draggable: 'true'}).addTo(proximityMap);
resizeMarker.on('drag', updateRuler);

var measureLine = new L.Polyline(
[centerLocation, resizeIconLocation ],
                            { color: "black", opacity: 0.5, stroke: true });

proximityMap.addLayer(measureLine);
measureLine._path.setAttribute("class", 'measuring-line-for-look');

var options = {
    minWidth: 50,
    autoPan: false,
    closeButton: true, // should the popups have a close option?
    displayTotalDistance: true,
    displayPartialDistance: false,
    className: 'measuring-label-tooltip' /*css label class name*/
    };
//                var totalDistancePopup = new L.Popup(options,measureLine);
var initialDistance = centerLocation.distanceTo(resizeIconLocation);

var measureCircle = L.circle(centerLocation, initialDistance).addTo(proximityMap);

function updateRuler(e) {
    var target = e.target;
    resizeIconLocation = target.getLatLng();
    measureLine.setLatLngs([centerLocation, resizeIconLocation]);
    setDistancePopup(centerLocation, resizeIconLocation)
    }


function setDistancePopup(startLatLng, endLatLng) {
    var centerPos = new L.LatLng((startLatLng.lat + endLatLng.lat) / 2,
    (startLatLng.lng + endLatLng.lng) / 2),
    distance = startLatLng.distanceTo(endLatLng);
    proximityDistance.val(distance.toFixed(2));
    measureCircle.setRadius(distance);
}
