$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select a Category",
        allowClear: true
    });

    // Configurar máscara para o campo amount com Cleave.js
    $("#amount").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

    $('#create_transaction').on('submit', function () {
        transformAmountDB($('#amount'));
    });

    $('#update_transaction').on('submit', function () {
        transformAmountDB($('#amount'));
    });
});



function transformAmountDB(amountField){
            
    // Pegar o valor formatado no campo
    let formattedValue = amountField.val(); // Exemplo: "R$ 10,99"

    // Remover o prefixo "R$" e os espaços (se existirem)
    formattedValue = formattedValue.replace(/R\$\s?/g, '');

    // Substituir a vírgula pelo ponto
    const rawValue = formattedValue.replace(',', '.');

    // Substituir o valor do campo pelo valor bruto
    amountField.val(rawValue);
}