import { Controller } from "@hotwired/stimulus";
import L from "leaflet";
import "leaflet/dist/leaflet.min.css";

const SIZE = 32;
L.Marker.prototype.options.icon = L.icon({
  iconUrl: "/marker.png",
  iconSize: L.point(SIZE, SIZE),
  iconAnchor: L.point(SIZE / 2, SIZE),
});

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ["lat", "long", "container"];

  map = null;
  mark = null;

  connect() {
    this.map = L.map(this.containerTarget, {
      center: [this.latTarget.value, this.longTarget.value],
      zoom: 13,
    });
    this.mark = L.marker([this.latTarget.value, this.longTarget.value]).addTo(this.map);

    const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
    }).addTo(this.map);

    this.map.on("click", (ev) => this.onMapClick(ev));
  }

  async onMapClick(ev) {
    this.mark.setLatLng(ev.latlng);
    this.latTarget.value = ev.latlng.lat;
    this.longTarget.value = ev.latlng.lng;
  }
}
