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
  map = null;
  async connect() {
    this.map = L.map(this.element, {
      center: [19.432608, -99.133209],
      zoom: 5,
    });
    const tiles = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
    }).addTo(this.map);

    const points = await fetch("/location/points");
    const locations = await points.json();
    for (let p of locations) {
      const marker = L.marker([p.lat, p.long]).addTo(this.map);
      console.log(p);
    }
  }
}
