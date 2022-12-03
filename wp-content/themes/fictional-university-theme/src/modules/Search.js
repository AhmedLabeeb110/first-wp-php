import $ from "jquery";

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.resultsDiv = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    // Calling the events method here makes sure that the event listeners get added to the page right away
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }

  // 2. Events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    //For adding an action based on Key Press, we need to target the entire document.
    $(document).on("keydown", this.keyPressDispatcher.bind(this));
    // The keydown event fires so immediately after keypress that it doesn't give a change the search field to update it's value,
    // so for searchfields we will need to use the keyup event
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  // 3. methods (function, action...)

  // setTimeout function takes in two arguments
  // First Argument - function name or fully defined function
  // Second Argument - duration after the function should run
  // Examples:
  // setTimeout(function(){}, delay) or setTimeout(functionName, delay)

  // clearTimeout function clears the ongoing setTimeout function that is about to show an output

  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.getJSON('http://fictional-university.local/wp-json/wp/v2/posts?search=' + this.searchField.val(), function(posts){
      alert(posts[0].title.rendered);
    })
  }

  //This is how you can find the keyCode
  // keyPressDispatcher(e) {
  //   console.log(e.keyCode);
  // }

  keyPressDispatcher(e) {
    if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) {
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
