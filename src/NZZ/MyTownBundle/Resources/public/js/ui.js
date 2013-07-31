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
});