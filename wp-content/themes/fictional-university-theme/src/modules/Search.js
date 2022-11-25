import $ from "jquery";

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    // Calling the events method here makes sure that the event listeners get added to the page right away 
    this.events();
  }

  // 2. Events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
  }

  // 3. methods (function, action...)
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active")
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active")
  }
}

export default Search;
