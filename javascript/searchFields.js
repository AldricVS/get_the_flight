/**
 * Listeners des champs de recherche de vol
 */
$(".airport-search").on("input", function(){
    /* On veut avoir la liste des aéroports qui correspondent à ce qu'écrit l'utilisateur.
     * Pour cela, on va récupérer le texte et l'envoyer à un script php, qui va nous renvoyer une liste d'options,
     * qu'on aura plus qu'à insérer cette liste dans la datalist associée à cet input.
     */
    
    var inputField = $(this);
    var inputFieldValue = inputField.val();

    //si le champ est vide, on vide aussi la datalist 
    if(inputFieldValue == ""){
        console.log("erase all");
        inputField.next("datalist").empty();
    }else{
        $.post("includes/search-airport.inc.php", {"airport-name": inputFieldValue}, function(data){
            inputField.next("datalist").html(data);
        });
    }
});