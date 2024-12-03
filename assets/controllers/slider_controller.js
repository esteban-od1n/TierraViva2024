import { Controller } from "@hotwired/stimulus";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
  static targets = ["sliderItem"];
  current = 0;

  connect() {
    this.sliderItemTargets[this.current].classList.remove("hidden");
  }

  goNext(ev) {
    this.sliderItemTargets[this.current].classList.add("hidden");
    this.current = (this.current + 1) % this.sliderItemTargets.length;
    this.sliderItemTargets[this.current].classList.remove("hidden");
  }

  goPrev(ev) {
    this.sliderItemTargets[this.current].classList.add("hidden");
    this.current =
      this.current > 0
        ? (this.current - 1) % this.sliderItemTargets.length
        : (this.current = this.sliderItemTargets.length - 1);
    this.sliderItemTargets[this.current].classList.remove("hidden");
  }
}
