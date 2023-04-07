import $ from 'jquery';

class MyNotes{
    constructor(){
      this.events()
    }

    events(){
      // The below line of code means: 
      // whenever you click anywhere within the parent unordered list(contains andy present or future notes), also it always exists when the page first loads 
      // And if the interior element matches the delete-note class
      $("#my-notes").on("click", ".delete-note", this.deleteNote);
      $("#my-notes").on("click", ".edit-note", this.editNote.bind(this))
      $("#my-notes").on("click", ".update-note", this.updateNote.bind(this))
      $(".submit-note").on("click", this.createNote.bind(this))
    }

    // Methods will go here

    //Edit method
    editNote(e){
      var thisNote = $(e.target).parents("li");
      if (thisNote.data("state") == "editable"){
         // make things read only
         this.makeNoteReadOnly(thisNote)
      } else {
        //make editable
        this.makeNoteEditable(thisNote)
      }
    }

    makeNoteEditable(thisNote){
      // removeAttr() and addClass() are handy JQuery methods. They are not built-in JS methods.
      // html() is a JQuery Method, it is used for replacing content 
      thisNote.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i> Cancel')
      thisNote.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
      thisNote.find(".update-note").addClass("update-note--visible")
      thisNote.data("state", "editable");
    }

    makeNoteReadOnly(thisNote){
      // removeAttr() and addClass() are handy JQuery methods. They are not built-in JS methods.
      // html() is a JQuery Method, it is used for replacing content
      
      // attr() is also a JQuery attribute
      // first argument - arrtibute name
      // second argument - attribute value  
      
      thisNote.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit')
      thisNote.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
      thisNote.find(".update-note").removeClass("update-note--visible")
      thisNote.data("state", "cancel");
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

    //Update method
    //Take in all the events(e)
    updateNote(e){

      // get the parent of target and save it inside a variable
      var thisNote = $(e.target).parents("li")
      // WP Rest API looks for very specific property names
      // To update data we must follow this format and provide the correct property names:
      var ourUpdatedPost = {
        //update the title
        'title': thisNote.find(".note-title-field").val(),
        //update the body content
        'content': thisNote.find(".note-body-field").val()
      }

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
        type: 'POST',
        // In JS we can send data through APIs using the data property 
        data: ourUpdatedPost, 
        // To delete a post, we need to prove to JavaScript that we are logged in.
        // We do that by passing a NONCE value as argument
        // NONCE stands for "A number used once or number once"
        // So, everytime we login successfully WP will generate a Nonce for us  
        // Now, go to functions.php and look for wp_localize_script
        success: (response) => {
          // slideUp() is a JQuery function that removes the element from the page using a nice "Slide Up" animation
          this.makeNoteReadOnly(thisNote)
          console.log("Congratulations")
          console.log(response)
        },
        error: (response) => {
          console.log("Sorry")
          console.log(response)
        }
      })
    }

    createNote(e){
      
      var ourNewPost = {
        //update the title
        'title': $(".new-note-title").val(),
        //update the body content
        'content': $(".new-note-body").val(),
        //By default every CREATED posts from the frontend get saved as drafts. 
        //Create the below object to set the type of status in which you want to create posts.
        //e.g. draft and publish   
        // Changing the visibility from 'Public' to 'Private' will make all the posts request as private posts, however, this is not the best practise
        // Becuase we can not rely on a client-side feature to force a status, this can be easily manipulated by hackers. We need to set a desired status from the back-end 
        'status': 'publish' 
      }

      $.ajax({
        beforeSend: (xhr) => {
          // This is how you pass down a little bit of extra information with your request.
          // First argument needs to perfectly match what WordPress is going to be on the lookout for
          // Second argument: pass the nonce
          xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
        },
        // We named the 'data' attribute as 'data-id' in the HTML, but when we use the JQuery data method we do not need
        // to write data- as argument
        url: universityData.root_url + '/wp-json/wp/v2/note/',
        type: 'POST',
        // In JS we can send data through APIs using the data property 
        data: ourNewPost, 
        // To delete a post, we need to prove to JavaScript that we are logged in.
        // We do that by passing a NONCE value as argument
        // NONCE stands for "A number used once or number once"
        // So, everytime we login successfully WP will generate a Nonce for us  
        // Now, go to functions.php and look for wp_localize_script
        success: (response) => {
          $(".new-note-title, .new-note-body").val('');
          //The prependTo() method inserts HTML elements at the beginning of the selected elements. Its a JQuery Method
          // The hide() method hides the selected elements. - JQuery Method
          // The slideDown() method slides-down (shows) the selected elements. - JQuery Method 

          // When an Api request becomes successful, it returns all the data of a post. We can access the data using JS expressions like this
          $(`
           <li data-id="${response.id}">
            <input readonly class="note-title-field" value="${response.title.raw}">
            <span class="edit-note"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
            <span class="delete-note"> <i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
            <textarea readonly class="note-body-field">${response.content.raw}</textarea>
            <span class="update-note btn btn--blue btn-small"> <i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
           </li>
          `).prependTo("#my-notes").hide().slideDown()
          this.makeNoteReadOnly(thisNote)
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