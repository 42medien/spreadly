<!-- form action="/deals/testerle_save" method="post" name="deal_form">

<?php //echo $pForm->render();?>
  <?php //echo $pForm['_csrf_token']->render(); ?>
	<input type="submit" class="button positive" value="<?php //echo __('Save', null, 'widget');?>" />
</form -->
<input type="text" name="q" id="query" />
<div class="ui-widget">
	<label for="taglist">Birds: </label>
	<input type="text" id="taglist" size="50" />
</div>


	<script>
	$(function() {
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#taglist" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				source: function( request, response ) {
					$.getJSON( "/deals/get_search_results", {
						term: extractLast( request.term )
					}, response );
				},
				search: function() {
					// custom minLength
					var term = extractLast( this.value );
					if ( term.length < 2 ) {
						return false;
					}
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});
	});
	</script>