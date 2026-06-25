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

submit.addEventListener('click', () => {
    let otp = '';

    notFullError.classList.add('hidden');
    
    try {
        inputs.forEach((input) => {
            if (input.value) {
                otp += input.value;
            } else {
                throw new Error();
            }
        });

        
    } catch {
        notFullError.classList.remove('hidden');
    }
});