import { Controller } from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  connect() {
    alert("a");
    this.element.textContent = "B";
  }
}
