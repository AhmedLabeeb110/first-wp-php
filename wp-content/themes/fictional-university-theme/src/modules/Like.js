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

    if (currentLikeBox.data("exists") == "yes") {
      this.deleteLike();
    } else {
      this.createLike();
    }
  }

  createLike() {
    alert("create test msg");
  }

  deleteLike() {
    alert("delete test msg");
  }
}

export default Like;