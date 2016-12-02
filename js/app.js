$('#loanForm').submit(function(event) {
    // Stop the browser from submitting the form.
    event.preventDefault();
});

function getPaymentPlan() {

    var loanForm = $('#loanForm');
    var loanFormData = $(loanForm).serialize();

    $.ajax({
        type: "GET",
        url: "LoanCalculator/getPaymentPlan",
        data: loanFormData,
        success: function(result){
            document.getElementById("paymentPlan").innerHTML = result;
        }
    });

}