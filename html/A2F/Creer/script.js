const inputs = document.querySelectorAll('.otp-input');

inputs.forEach((input, index) => {
    input.value = "";

    input.addEventListener("input", (e) => {
        const val = e.target.value.replace(/[^0-9]/g, "");
        e.target.value = val;
        if (val) {
            input.classList.add("filled");
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        } else {
            input.classList.remove("filled");
        }
    });

    input.addEventListener("keydown", (e) => {
        if (e.key == "Backspace" && !input.value && index > 0) {
            inputs[index - 1].focus();
            inputs[index - 1].value = inputs[index - 1].value;
            inputs[index - 1].classList.remove("filled");
        }
    })
})

const submit = document.getElementById('submit');
const notFullError = document.getElementById('not-full');
const incorrectOTPError = document.getElementById('incorrect-otp');
const secret = document.getElementById('secret');

submit.addEventListener('click', () => {
    let OTP = '';

    notFullError.classList.add('hidden');
    incorrectOTPError.classList.add('hidden');
    
    try {
        inputs.forEach((input) => {
            if (input.value) {
                OTP += input.value;
            } else {
                throw new Error();
            }
        });

        fetch('/API/A2F.php', {
            method: 'POST',
            body: JSON.stringify({
                secret: secret.value, 
                otp: OTP
            })
        }).then((response) => {
            if (response.ok) {
                window.location = "/Catalogue";
            } else {
                console.log('jaaj');
                throw new Error('IncorrectOTP');
            }
        }).catch(() => {
            incorrectOTPError.classList.remove('hidden');
        })
    } catch (e) {
        notFullError.classList.remove('hidden');
    }
});