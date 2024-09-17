function updateOtherSamlState() {
    samlprop = document.querySelector("select#edit-samlprop");
    samlother = document.querySelector("div.form-item--samlother");
    console.log(samlother);
    if(samlprop.value != "other") {
        samlother.classList.add("hide");
        samlother.classList.remove("show");
    } else {
        samlother.classList.add("show");
        samlother.classList.remove("hide");
    }
}
samlprop = document.querySelector("select#edit-samlprop");
samlprop.addEventListener('change',updateOtherSamlState);
updateOtherSamlState();