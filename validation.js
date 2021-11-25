
    function checkForm() {
        const form = document.getElementById('orderForm');
        if(!form.checkValidity()) {
        document.getElementById('orderFormDiv').innerHTML = form.validationMessage();
    }
    }
