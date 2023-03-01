import $ from 'jquery';

class MyNotes{
    constructor(){
      this.events()
    }

    events(){
      $(".delete-note").on("click", this.deleteNote);
    }

    // Methods will go here
    deleteNote(){
      $.ajax({
        beforeSend: (xhr) => {
          // This is how you pass down a little bit of extra information with your request.
          // First argument needs to perfectly match what WordPress is going to be on the lookout for
          // Second argument: pass the nonce
          xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
        },
        url: universityData.root_url + '/wp-json/wp/v2/note/185',
        type: 'DELETE',
        // To delete a post, we need to prove to JavaScript that we are logged in.
        // We do that by passing a NONCE value as argument
        // NONCE stands for "A number used once or number once"
        // So, everytime we login successfully WP will generate a Nonce for us  
        // Now, go to functions.php and look for wp_localize_script
        success: (response) => {
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