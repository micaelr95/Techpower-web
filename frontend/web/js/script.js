var precoArray = $('.preco');
var quantidadeArray = $('.quantidade');
var subtotal = $('.subtotal');
var totalArray = $('.total');

fillTotal();

for(pos = 0; pos < quantidadeArray.length; pos++) {
    quantidadeArray[pos].addEventListener("change", fillTotal());
}

function fillTotal() {
    for(i = 0; i < precoArray.length; i++) {
        subtotal[i].textContent = parseFloat(parseFloat(precoArray[i].textContent) * parseInt(quantidadeArray[i].value)) + '€';
    }
    let total = getTotal();
    totalArray[0].textContent = total + '€';
    totalArray[1].textContent = total + '€';
}


//Previne que a quantidade de um item no carrinho fique a NULL
const numInputs = document.querySelectorAll('input[type=number]')

numInputs.forEach(function(input) {
  input.addEventListener('change', function(e) {
    if (e.target.value == '') {
      e.target.value = 1
      total();
    }
  })
})

function getTotal() {
    var total = 0;
    for(i = 0; i < precoArray.length; i++) {
        total += parseFloat(precoArray[i].textContent) * parseInt(quantidadeArray[i].value);
    }
    return total;
}

// Open pay window for Paypal
paypal.Buttons({
    createOrder: function(data, actions) {
        // This function sets up the details of the transaction, including the amount and line item details.
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: getTotal()
                }
            }]
        });
    },
    onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            window.location.href = '/sale/create';
        });
    }
}).render('#paypal-button-container');