$('#myModal').modal({ show: false });

$('.flatbtn, .popup').click(function(e){
  $('.modal-body', '#myModal').load($(this).attr('href'), function() {
    $('#myModal').modal('show');
  })
  e.preventDefault();
});
