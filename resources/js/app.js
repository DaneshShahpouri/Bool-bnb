import './bootstrap';
import '~resources/scss/app.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])


// CHECK PASSWORD CONFIRM
//-------------------------------------------------------
let inputPassword = document.getElementById('password');
let inputPasswordConfirm = document.getElementById('password-confirm');
let message = document.getElementById('error-password-message');
let button = document.getElementById('button');
button.disabled = true;
message.innerText = ' '
message.style = "font-size:.5em; color:red; padding:0; margin:0"
function checkPassword() {
    if (inputPassword.value != inputPasswordConfirm.value) {
        button.disabled = true;
        inputPasswordConfirm.style = "border:1px solid red"
        message.innerText = 'passwords must match'
    } else {
        button.disabled = false
        inputPasswordConfirm.style = ""
        message.innerText = ""
    }
}
inputPassword.addEventListener('change', () => { checkPassword() })
inputPasswordConfirm.addEventListener('change', () => { checkPassword() })
//-------------------------------------------------------
// /CHECK PASSWORD CONFIRM
