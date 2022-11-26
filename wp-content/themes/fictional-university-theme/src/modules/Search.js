import $ from "jquery";

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    // Calling the events method here makes sure that the event listeners get added to the page right away
    this.events();
    this.isOverlayOpen = false;
  }

  // 2. Events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    //For adding an action based on Key Press, we need to target the entire document.
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
  }

  // 3. methods (function, action...)

  //This is how you can find the keyCode
  // keyPressDispatcher(e) {
  //   console.log(e.keyCode);
  // }

  keyPressDispatcher(e) {
    if (e.keyCode == 83 && !this.isOverlayOpen) {
      this.openOverlay();
    }
    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    console.log("Our open methid just ran!")
    this.isOverlayOpen = true;
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    console.log("Our close methid just ran!")
    this.isOverlayOpen = false;
  }
}

export default Search;
