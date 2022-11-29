import $ from "jquery";

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    // Calling the events method here makes sure that the event listeners get added to the page right away
    this.events();
    this.isOverlayOpen = false;
    this.typingTimer;
  }

  // 2. Events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    //For adding an action based on Key Press, we need to target the entire document.
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    this.searchField.on("keydown", this.typingLogic.bind(this));
  }

  // 3. methods (function, action...)

  // setTimeout function takes in two arguments
  // First Argument - function name or fully defined function
  // Second Argument - duration after the function should run
  // Examples:
  // setTimeout(function(){}, delay) or setTimeout(functionName, delay)

  // clearTimeout function clears the ongoing setTimeout function that is about to show an output

  typingLogic() {
    clearTimeout(this.typingTimer)
    this.typingTimer = setTimeout(function () {
      console.log("This is a timeout test");
    }, 2000);
  }

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
    console.log("Our open methid just ran!");
    this.isOverlayOpen = true;
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    console.log("Our close methid just ran!");
    this.isOverlayOpen = false;
  }
}

export default Search;
