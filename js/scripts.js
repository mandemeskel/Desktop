(function ($, root, undefined) {

	$(function () {

		'use strict';

		/**
		 * Sends the email information when
		 * the submit button is clicked
		 */
		$( "#contact_form" ).submit(
			function( event ) {

				event.preventDefault();

				var info = $( this ).serializeArray();

				info.push( {
					name: "action",
					value: $( this ).data( "wp-action" )
				} );

				var submit_btn = $( this ).find(
					"*[type='submit']" );

				var alert_msg = $( this ).children(
					"*[role='alert']" );

				if( alert_msg == undefined ) {

					alert_msg = '<div class="alert alert-info hidden" role="alert"></div>';

					$( this ).append( alert_msg );

				 }

				var settings = {

					beforeSend: function( jqXHR, settings ) {

						$( submit_btn ).attr(
							"disabled", "disabled" );

						$( alert_msg ).text( "sending..." );

						$( alert_msg ).attr( "class", "" );

						$( alert_msg ).addClass( "alert alert-info" );

					},

					data: info,

					error: function( jqXHR, settings, errorThrown ) {

						console.log( response );

						$( submit_btn ).removeAttr( "disabled" )

						$( alert_msg ).removeClass( "alert-info" );

						$( alert_msg ).addClass( "alert-danger" );

						$( alert_msg ).text( "Oh snap, something went wrong. Try again later." );

					},

					type: $( this ).attr( "method" ),

					success: function( response, jqXHR, settings ) {

						console.log( response );

						var data = jQuery.parseJSON( response );

						$( alert_msg ).removeClass( "alert-info" );

						if( data.status ) {

							$( alert_msg ).addClass( "alert-success" );

						} else {

							$( alert_msg ).addClass( "alert-danger" );

							$( submit_btn ).removeAttr( "disabled" )

						}

						$( alert_msg ).text( data.response );

					}

				}

				$.ajax(
					$( this ).attr( "action" ),
					settings
				);

			}
		);

	});

})(jQuery, this);
