const formElementsValues = [];

changeToInput = () => {

    let buttons = document.getElementById('buttonProfile');
    buttons.innerHTML = "<button class='btn btn-danger' onclick='reverseInput()' style='margin-right: 2rem'>Mégse</button>";
    buttons.innerHTML += "<button type='submit' class='btn btn-success' style='margin-left: 2rem'>Kész</button>";

    let formElements = document.getElementsByClassName('userInfoInputField');
    for (let i = 0; i < formElements.length; i++){
        formElementsValues[i] = formElements[i].value;
        formElements[i].disabled = false;
        $(formElements[i]).css("background-color","white");
    }
    $('#genderReveal').css("display","block");
    $('#user_sexInput').css("display","none");
}

reverseInput = () =>{
    let buttons = document.getElementById('buttonProfile');
    buttons.innerHTML = "<button class='btn btn-info' onclick='changeToInput()'>Módosítás</button>";

    let formElements = document.getElementsByClassName('userInfoInputField');
    for (let i = 0; i < formElements.length; i++){
        formElements[i].value = formElementsValues[i];
        formElements[i].disabled = true;
        $(formElements[i]).css("background-color","#3f3f3f");
    }

    $('#genderReveal').css("display","none");
    $('#user_sexInput').css("display","block");
}
