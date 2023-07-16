import $ from "jquery";

class Like {
  constructor() {
    this.events();
  }

  events() {
    $(".like-box").on("click", this.ourClickDispatcher.bind(this));
  }

  // methods
  ourClickDispatcher(e) {
    // Rough Code
    // if ($(".like-box").data("exists") == "yes") {
    //   this.deleteLike();
    // } else {
    //   this.createLike();
    //}

    // In JavaScript, an event is an object that represents an action that has taken place in the browser. Events can be triggered by the user, such as when they click a button, or by the browser, such as when a page loads.

    // When an event is triggered, it is dispatched to the element that is associated with it. The element can then handle the event by executing a JavaScript function.

    // The e.target property in JavaScript refers to the element where the event occurred. It is a read-only property and is different from the e.currentTarget property, which returns the element whose event listener triggered the event.

    var currentLikeBox = $(e.target).closest(".like-box");

    //JQuery data method only looks at the data attribute values once when the page first loads, so in the code below we will be using a attr method instead
    if (currentLikeBox.attr("data-exists") == "yes") {
      this.deleteLike(currentLikeBox);
    } else {
      this.createLike(currentLikeBox);
    }
  }

  createLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        // This is how you pass down a little bit of extra information with your request.
        // First argument needs to perfectly match what WordPress is going to be on the lookout for
        // Second argument: pass the nonce
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/university/v1/manageLike',
      type: 'POST',
      data: { 'professorId' : currentLikeBox.data('professor') },
      success: (response) => {
        currentLikeBox.attr('data-exists', 'yes');
        // parseInt() is a JS method that parses a string to number
        // we nee to pass in two arguments within it
        // first argument - the string of text you want to convert into number
        // second argument - the number you want to use as your base - the most preferred number is 10 as humans mostly use number system based around 10.
        var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
        likeCount++;
        currentLikeBox.find(".like-count").html(likeCount);
        // the wordpress server sends the ID number of the new post as response that's why we are passing the ID as second argument
        currentLikeBox.attr("data-like", response);
        console.log(response)
      },
      error: (response) => {
        console.log(response)
      }
    })
  }


  deleteLike(currentLikeBox) {
    $.ajax({
      beforeSend: (xhr) => {
        // This is how you pass down a little bit of extra information with your request.
        // First argument needs to perfectly match what WordPress is going to be on the lookout for
        // Second argument: pass the nonce
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + '/wp-json/university/v1/manageLike',
      data: {'like': currentLikeBox.attr('data-like')},
      type: 'DELETE',
      success: (response) => {
        console.log(response)
        // Copied and pasted the code from above and made changes accordingly
        currentLikeBox.attr('data-exists', 'no');
        var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);
        likeCount--;
        currentLikeBox.find(".like-count").html(likeCount);
        currentLikeBox.attr("data-like", '');
      },
      error: (response) => {
        console.log(response)
      }
    })
  }
}

export default Like;
