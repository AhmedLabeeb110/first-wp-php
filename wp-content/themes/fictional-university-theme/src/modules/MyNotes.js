import $ from 'jquery';

class MyNotes{
    constructor(){
      this.events()
    }

    events(){
      $(".delete-note").on("click", this.deleteNote);
      $(".edit-note").on("click", this.editNote)
    }

    // Methods will go here

    //Edit method
    editNote(e){
      var thisNote = $(e.target).parents("li");
      // removeAttr() and addClass() are handy JQuery methods. They are not built-in JS methods.
      thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
      thisNote.find(".update-note").addClass("update-note--visible")
    }

    //Delete method
    //Take in all the events(e)
    deleteNote(e){

      // get the parent of target and save it inside a variable
      var thisNote = $(e.target).parents("li")

      $.ajax({
        beforeSend: (xhr) => {
          // This is how you pass down a little bit of extra information with your request.
          // First argument needs to perfectly match what WordPress is going to be on the lookout for
          // Second argument: pass the nonce
          xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
        },
        // We named the 'data' attribute as 'data-id' in the HTML, but when we use the JQuery data method we do not need
        // to write data- as argument
        url: universityData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
        type: 'DELETE',
        // To delete a post, we need to prove to JavaScript that we are logged in.
        // We do that by passing a NONCE value as argument
        // NONCE stands for "A number used once or number once"
        // So, everytime we login successfully WP will generate a Nonce for us  
        // Now, go to functions.php and look for wp_localize_script
        success: (response) => {
          // slideUp() is a JQuery function that removes the element from the page using a nice "Slide Up" animation
          thisNote.slideUp()
          console.log("Congratulations")
          console.log(response)
        },
        error: (response) => {
          console.log("Sorry")
          console.log(response)
        }
      })
    }
}

export default MyNotes;