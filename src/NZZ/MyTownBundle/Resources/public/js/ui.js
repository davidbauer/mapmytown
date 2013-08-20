$( document ).ready(function() {
  $('.embed_popover').popover({
    'title': 'Embed this map',
    'content':'<textarea name="embedding_code" id="embedding_code" cols="10" rows="5">[Insert Embedding Code here.]</textarea>',
    'html': true,
    'placement': 'bottom',

  })
  $('.embed_popover').click(function(){
    $('#embedding_code').select();
  })
  /*
  $('.submit__marker__section').hide();

  $('#submit__wisdom__btn').click(function(){
    $('.comments__section').hide();
    $('.submit__wisdom__section').hide();
  })
  $('#cancel__marker__btn').click(function(){
    $('.comments__section').show();
    $('.submit__comment__section').hide();
    $('.submit__marker__section').show();
  })
  $('#submit__marker__btn').click(function(){
    $('.submit__marker__section').hide();
  })
  */
});