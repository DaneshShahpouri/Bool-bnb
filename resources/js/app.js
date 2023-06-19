import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
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
