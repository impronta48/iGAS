$(document).ready(function() {
    function e() {
        $("#wizard").smartWizard("showMessage", "Finish Clicked");
    }
    $("#wizard").smartWizard();
    $("#wizardVertical").smartWizard({
        transitionEffect: "slide"
    });
});