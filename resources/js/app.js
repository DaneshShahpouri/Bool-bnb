
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
   
}
//-------------------------------------------------------
// /CHECK PASSWORD CONFIRM



//Chiamata Axios per suggerimento indirizzi
//-------------------------------------------------------
let input = document.getElementById('addressCreate');
let inputEdit = document.getElementById('addressCreateEdit');
let suggest = document.getElementById('create-suggest');
let suggestEdit = document.getElementById('edit-suggest');

//suggest.innerHTML = "<li class='_first-li'>" + 'Forse cercavi:' + "</li>"

input?.addEventListener('input', () => {
    advicedCity()
})

inputEdit?.addEventListener('input', () => {
    advicedCity()
})

window.addEventListener('click', () => {
    if (suggest && suggest.innerHTML != '') {
        suggest.innerHTML = ''
    } else if (suggestEdit && suggestEdit != '') {
        suggestEdit.innerHTML = ''
    }
})


function advicedCity() {
    let searchInput = input?.value;
    let searchInputEdit = inputEdit?.value;
    let arraySuggestion = []
    if (searchInput) {
        if (searchInput.length > 3) {
            axios.get('https://api.tomtom.com/search/2/geocode/' + encodeURIComponent(searchInput) + '.json?countrySet=IT&key=9LYFxo01VqErOpYtelpWGSFzw2eB6a4r').then(res => {
                arraySuggestion = []
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

                suggest.innerHTML = ''
                //suggest.innerHTML = "<li class='_first-li'>" + 'Forse cercavi:' + "</li>"
                arraySuggestion.forEach(element => {
                    suggest.innerHTML += '<li class="list"><i class="fa-solid fa-location-dot _location-icon"></i>' + element.address.freeformAddress + '</li>'
                });

                document.querySelectorAll('.list').forEach(listEl => {
                    listEl.addEventListener('click', () => {
                        input.value = listEl.innerText;
                        suggest.innerHTML = ''
                        isValidAddress = true;
                        messageAddress.innerText = ''
                    })
                })


                if (res.data.results[0].matchConfidence.score < 1) {
                    isValidAddress = false
                } else {
                    isValidAddress = true
                }

            })
        } else {
            suggest.innerHTML = ''
        }
    } else if (searchInputEdit) {

        if (searchInputEdit.length > 3) {
            axios.get('https://api.tomtom.com/search/2/geocode/' + encodeURIComponent(searchInputEdit) + '.json?countrySet=IT&key=9LYFxo01VqErOpYtelpWGSFzw2eB6a4r').then(res => {
                arraySuggestion = []
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

                suggestEdit.innerHTML = ''
                //suggestEdit.innerHTML = "<li class='_first-li'>" + 'Forse cercavi:' + "</li>"
                arraySuggestion.forEach(element => {
                    suggestEdit.innerHTML += '<li class="list"><i class="fa-solid fa-location-dot _location-icon"></i>' + element.address.freeformAddress + '</li>'
                });

                document.querySelectorAll('.list').forEach(listEl => {
                    listEl.addEventListener('click', () => {
                        inputEdit.value = listEl.innerText;
                        suggestEdit.innerHTML = ''
                        isValidAddressEdit = true;
                        messageAddressEdit.innerText = ''
                    })
                })


                if (res.data.results[0].matchConfidence.score < 1) {
                    isValidAddressEdit = false
                } else {
                    isValidAddressEdit = true
                }

            })
        } else {
            suggestEdit.innerHTML = ''
        }
    }
}
//-------------------------------------------------------
//Chiamata Axios per suggerimento indirizzi

