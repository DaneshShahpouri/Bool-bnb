
import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import axios from 'axios';
delete axios.defaults.headers.common['X-Requested-With'];
import.meta.glob([
    '../img/**'
])


// CHECK PASSWORD CONFIRM
//-------------------------------------------------------
if (document.getElementById('password-confirm')) {
    let form = document.getElementById('register-form');
    let inputPassword = document.getElementById('password');
    let inputPasswordConfirm = document.getElementById('password-confirm');
    let message = document.getElementById('error-password-message');
    message.innerText = ' '
    message.style = "font-size:.5em; color:red; padding:0; margin:0"
    function checkPassword() {
        if (inputPassword.value != inputPasswordConfirm.value) {
            inputPasswordConfirm.style = "border:1px solid red"
            message.innerText = 'passwords must match'
        } else {
            inputPasswordConfirm.style = ""
            message.innerText = ""
        }
    }
    form.onsubmit = function onSubmit() {
        if (inputPassword.value != inputPasswordConfirm.value) {
            return false;
        }
        else {
            return true;
        }
    }
    inputPassword.addEventListener('change', () => { checkPassword() })
    inputPasswordConfirm.addEventListener('change', () => { checkPassword() })
    console.log('controllo attivo')
}
//-------------------------------------------------------
// /CHECK PASSWORD CONFIRM



//Chiamata Axios per suggerimento indirizzi
//-------------------------------------------------------
let input = document.getElementById('addressCreate');
let suggest = document.getElementById('create-suggest');
//suggest.innerHTML = "<li class='_first-li'>" + 'Forse cercavi:' + "</li>"

input.addEventListener('input', () => {
    advicedCity()
})


function advicedCity() {
    let searchInput = input.value;
    let arraySuggestion = []
    if (searchInput.length > 3) {
        axios.get('https://api.tomtom.com/search/2/geocode/' + encodeURIComponent(searchInput) + '.json?countrySet=IT&key=9LYFxo01VqErOpYtelpWGSFzw2eB6a4r').then(res => {
            arraySuggestion = []
            //console.log(res.data.results[0])
            let firstCountry = res.data.results[0]
            let secondCountry = res.data.results[1]
            let thirdCountry = res.data.results[2]

            if (firstCountry != undefined) {
                arraySuggestion.push(firstCountry)
            }
            if (secondCountry != undefined && secondCountry != firstCountry) {
                arraySuggestion.push(secondCountry)
            }
            if (thirdCountry != undefined && thirdCountry != firstCountry && thirdCountry != secondCountry) {
                arraySuggestion.push(thirdCountry)
            }

            console.log(arraySuggestion)
            suggest.innerHTML = ''
            suggest.innerHTML = "<li class='_first-li'>" + 'Forse cercavi:' + "</li>"
            arraySuggestion.forEach(element => {
                suggest.innerHTML += "<li>" + element.address.freeformAddress + "</li>"
            });
        })
    }
}
//-------------------------------------------------------
//Chiamata Axios per suggerimento indirizzi

