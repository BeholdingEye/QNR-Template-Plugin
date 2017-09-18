/* ==================================================================
 *
 *            QNR_TEMPLATE_PLUGIN JAVASCRIPT 1.0.0
 * 
 * ================================================================== */


(function(){
    window.addEventListener("load", function() {
        
        afterLoad();
        
        // ----------------------- Validate email on plugin settings page
        // HTML5 email input tag can validate, we're just testing the plugin
        var sBtn = document.getElementById('submit');
        sBtn.onclick = function(event) {
            var emailValue = document.getElementById("qnr_template_settings_array_b").value; // Email input
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test(emailValue)) {
                alert("Invalid email.");
                event.stopPropagation();
                event.preventDefault();
            } // Else do nothing, let the PHP code run
        }
        
    }, false);
    
})()

function afterLoad() {
    console.log("QNR_TEMPLATE_PLUGIN admin page loaded OK");
}