import $ from "jquery";

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML();
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
    // so for searchfields we will need to use the keyup event.
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  // 3. methods (function, action...)

  // setTimeout function takes in two arguments
  // First Argument - function name or fully defined function
  // Second Argument - duration after the function should run
  // Examples:
  // setTimeout(function(){}, delay) or setTimeout(functionName, delay)

  // clearTimeout function clears the ongoing setTimeout function that is about to show an output.

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

  //Instead of binding we can use Arrow functions
  getResults() {
    // First Argument: the API URL 
    // Second Argument: the function you want to call

    // The data received from the API call will pass all the data to the function 
    // So within the brackets we need to pass in a parameter to receive the incoming data. 
    // Also make sure to use the ES6 arrow function so that the value of the This Keyword doesn't get modified.
    $.getJSON(universityData.root_url + "/wp-json/university/v1/search?term=" + this.searchField.val(), (results) => {
      this.resultsDiv.html(`
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${
              results.generalInfo.length
                ? '<ul class="link-list min-list">'
                : "<p>No general information matches that search.</p>"
            }
             ${results.generalInfo
               .map(
                 (item) =>
                 //Got the item.type from Postman API call
                   `<li><a href="${item.permalink}">${item.title}</a> ${item.postType == 'post' ? `by ${item.authorName}`: ''}</li>`
               )
               .join("")}
             ${results.generalInfo.length ? "</ul>" : ""}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${
              results.programs.length
                ? '<ul class="link-list min-list">'
                : `<p> No programs match that search. <a href="${universityData.root_url}/programs">View all programs</a> </p>`
            }
             ${results.programs
               .map(
                 (item) =>
                 //Got the item.type from Postman API call
                   `<li><a href="${item.permalink}">${item.title}</a></li>`
               )
               .join("")}
             ${results.programs.length ? "</ul>" : ""}
            <h2 class="search-overlay__section-title">Professors</h2>
            ${
              results.professors.length
                ? '<ul class="professor-cards">'
                : `<p> No professors match that search.</p>`
            }
             ${results.professors
               .map(
                 (item) =>
                 `<li class="professor-card__list-item">
                 <a class="professor-card" href="${item.permalink}">
                  <img src="${item.image}" alt="" class="professor-card__image">
                  <span class="professor-card__name">${item.title}</span>
                 </a>
               </li>`
               )
               .join("")}
             ${results.professors.length ? "</ul>" : ""}
          </div>
          <div class="one-third">
           <h2 class="search-overlay__section-title">Campuses</h2>
           ${
            results.campuses.length
              ? '<ul class="link-list min-list">'
              : `No campuses match the search <a href="${universityData.root_url}/campuses">View all campuses</a>`
          }
           ${results.campuses
             .map(
               (item) =>
               //Got the item.type from Postman API call
                 `<li><a href="${item.permalink}">${item.title}</a></li>`
             )
             .join("")}
           ${results.campuses.length ? "</ul>" : ""}

           <h2 class="search-overlay__section-title">Events</h2>
           ${
            results.events.length
              ? ''
              : `No events match the search <a href="${universityData.root_url}/events">View all events</a>`
          }
           ${results.events
             .map(
               (item) =>
               //Got the item.type from Postman API call
                 `<div class="event-summary">
                 <a class="event-summary__date t-center" href="${item.permalink}">
                   <span class="event-summary__month">
                    ${item.month}
                   </span>
                   <span class="event-summary__day">
                     ${item.day}
                   </span>
                 </a>
                 <div class="event-summary__content">
                   <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">
                       ${item.title}
                     </a></h5>
                   <p> ${item.description}
                     <a href="${item.permalink}" class="nu gray">Learn more</a>
                   </p>
                 </div>
               </div>`
             )
             .join("")}
           ${results.events.length ? "</ul>" : ""}
          </div>
        </div>
      `);
      this.isSpinnerVisible = false;
    });
  }

  //This is how you can find the keyCode
  // keyPressDispatcher(e) {
  //   console.log(e.keyCode);
  // }

  keyPressDispatcher(e) {
    if (
      e.keyCode == 83 &&
      !this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    ) {
      this.openOverlay();
    }
    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.searchField.val('');
    //The JQuery focus method has been depreciated, however the JS Focus method still works
    //The line of code below will not work 
    //Look into this later
    // setTimeout(() => this.searchField.focus(), 301);
    //But the line of code below will work
    setTimeout(() => this.searchField.trigger('focus'), 301);
    console.log("Our open methid just ran!");
    this.isOverlayOpen = true;
    // This keeps the openOverlay method enabled when js is enabled in the browsers and prevents page redirection when JS is enabled. vice versa
    return false
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    console.log("Our close methid just ran!");
    this.isOverlayOpen = false;
  }

  //appending allows us to add HTML at the bottom of the HTML body tag
  addSearchHTML() {
    $("body").append(`
    <div class=" search-overlay">
    <div class="search-overlay__top">
      <div class="container">
       <div class="fa fa-search search-overlay__icon" aria-hidden="true"></div>
       <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
       <div class="fa fa-window-close search-overlay__close" aria-hidden="true"></div>
      </div>
    </div>
    <div class="container">
     <div id="search-overlay__results"></div>
    </div>
 </div>
    `);
  }
}

export default Search;
