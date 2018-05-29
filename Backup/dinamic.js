$(document).ready(function() {
  $("#monto").on("change keyup paste", function() {
    var monto = $("#monto").val();
  });
});

function splitValue(value, index) {
  return value.substring(0, index) + "," + value.substring(index);
}
