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


  /**
   * Sharing
   */
  function getEncodedLocation() {
    var link = document.referrer;
    if (!link) link = location.href;
    return encodeURIComponent(link);
  }

  $(document).on('click', '[data-action="share-twitter"]', function(evt) {
    evt.preventDefault();
    window.open(
      'https://twitter.com/share?url='+getEncodedLocation(),
      'twitter-share-dialog',
      'width=626,height=436'
    );
  });

  $(document).on('click', '[data-action="share-facebook"]', function(evt) {
    evt.preventDefault();
    window.open(
      'https://www.facebook.com/sharer/sharer.php?u='+getEncodedLocation(),
      'facebook-share-dialog',
      'width=626,height=436'
    );
  });
});
