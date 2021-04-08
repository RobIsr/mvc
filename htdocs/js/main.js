(function () {
    let rolledDices = document.getElementsByClassName("rolled-dices");

    for (let i = 0; i < rolledDices.children.length; i++) {
        rolledDices[i].addEventListener("click", function() {
            fetch("/dice/game", {
                method: "POST", 
                body: JSON.stringify(data)
              }).then(res => {
                console.log("Request complete! response:", res);
              });
        }); 
    }
})();