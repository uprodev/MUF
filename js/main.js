( function( $ ) {
	// let select = $('.select_beauty');
	// if(select.length){
	// 	select.each(function (){
	// 		$(this).select2({
	// 			placeholder: {
	// 				text: $(this).data('placeholder')
	// 			},
	// 		});
	// 		$(this).val();
	//
	// 	})
	// }
	// let select_2 = $('.select2-country');
	// if(select_2.length){
	// 	select_2.each(function (){
	// 		$(this).select2({
	// 			placeholder: {
	// 				text: $(this).data('placeholder')
	// 			},
	// 		});
	// 		$(this).val();
	//
	// 	})
	// }
	Fancybox.bind("[data-fancybox]", {
		// Your custom options
	});

	/**
	 * Ajax to create Workshop form
	 */
	$(document).on('click', '.submit-workshop', function (e){
		e.preventDefault();

		let button = $(this),
			form = $('.workshop-management'),
			form_data = form.serialize();

		form_data = form_data+'&action=add_workshop'

		$.ajax({
			url: muf.ajaxurl,
			data: form_data,
			type : 'POST',
			success : function ( data ){
				$('.success_box .success_text_1').show();
				$('.success_box .success_text_2').hide();
				$('.success_box .success_text_3').hide();

				Fancybox.close();
				var instance = Fancybox.show([
					{
						src: "#success_box",
						type: "inline"
					}
				]);

				instance.close = function() {
					location.reload();
				};
			}
		})

		return false;
	})
	/**
	 * End
	 */

	/**
	 * Ajax to populate data to Workshop form in PoPup
	 */
	$(document).on('click', '.update_workshop-js', function (e){
		e.preventDefault();

		let button = $(this),
			workshop_id = button.data('workshop_id');

		$.ajax({
			type: 'GET',
			url: '/wp-json/wp/v2/workshop/' + workshop_id,
			dataType: 'json',
			cache: false,
			success : function ( workshopPost ){
				let acf = workshopPost.acf_fields,
				form = $('#update_workshop');
				form.find('input[name="workshop_id"]').val(workshop_id).change();
				form.find('input[name="title"]').val(workshopPost.title.rendered).change();
				acf.country_list.forEach(function (currentValue, index, array){
					form.find('select[name="countries[]"] option[value="' + currentValue.value + '"]').prop("selected", true);
				});
				form.find('textarea[name="emails"]').val(acf.email_list).change();
				form.find('select[name="status"]').val(acf.status.value).change();

				// $('#update_workshop .workshop-management-update').html(data);
				Fancybox.show([{ src: "#update_workshop", type: "inline" }]);
			}
		})

		return false;
	})
	/**
	 * End
	 */

	/**
	 * Ajax to update Workshop forms
	 */
	$(document).on('click', '.update-workshop', function (e){
		e.preventDefault();

		let button = $(this),
			form = $('.workshop-management-update'),
			workshop_id = form.find('input[name="workshop_id"]').val(),
			form_data = form.serialize();

		form_data = form_data+'&action=update_workshop&workshop_id='+workshop_id;

		$.ajax({

			url: muf.ajaxurl,
			data: form_data,
			type : 'POST',
			success : function ( data ){
				$('.success_box .success_text_2').show();
				$('.success_box .success_text_1').hide();
				$('.success_box .success_text_3').hide();
				Fancybox.close();
				var instance = Fancybox.show([
					{
						src: "#success_box",
						type: "inline"
					}
				]);

				instance.close = function() {
					location.reload();
				};
			}
		})

		return false;
	})
	/**
	 * End
	 */

	/**
	 * Ajax to submit Workshop and create new post
	 */
	$(document).on('click', '.submit-workshop', function (e){
		e.preventDefault();
		let button = $(this),
			form = $('.workshop-form'),
			form_data = form.serialize();

		form_data = form_data+'&action=add_request';

		$.ajax({
			url: muf.ajaxurl,
			data: form_data,
			type : 'POST',
			success : function ( data ){
				$('.success_box .success_text_2').hide();
				$('.success_box .success_text_1').hide();
				$('.success_box .success_text_3').show();
				var instance = Fancybox.show([
					{
						src: "#success_box",
						type: "inline"
					}
				]);
				instance.close = function() {
					location.reload();
				};
			}
		})
		return false;
	})
	/**
	 * End
	 */

	/**
	 * Ajax for Search field in Workshop form Start
	 */
	$(document).on('input', '.ajax-crop', function (){
		let input = $(this);
		$.ajax({
			url: muf.ajaxurl,
			data: {
				'action': 'ajax_crop',
				'search' : input.val()
			},
			type : 'POST',
			success : function ( data ){
				if(input.val().length >= 2){
					input.parent().find('.search-box').html(data);
				}
				else{
					input.parent().find('.search-box').html('');
				}
			}
		})
	})

	$(document).on('click', '.search-value-crop', function (){
		let $this = $(this);

		$('.ajax-crop').val($this.data('value')).change();
		$('.ajax-crop-hidden').val($this.data('id')).change();
		$('.ajax-crop').parent().find('.search-box').html('');
	})

	$(document).on('input', '.ajax-target', function (){
		let input = $(this);
		$.ajax({
			url: muf.ajaxurl,
			data: {
				'action': 'ajax_target',
				'search' : input.val()
			},
			type : 'POST',
			success : function ( data ){
				if(input.val().length >= 2){
					input.parent().find('.search-box').html(data);
				}
				else{
					input.parent().find('.search-box').html('');
				}
			}
		})
	})
	$(document).on('click', '.search-value-target', function (){
		let $this = $(this);

		$('.ajax-target').val($this.data('value')).change();
		$('.ajax-target-hidden').val($this.data('id')).change();
		$('.ajax-target').parent().find('.search-box').html('');
	})
	/**
	 * End
	 */

	/**
	 * Priority Select
	 */
	// let priority_select = $('.priority_select');
	// $(document).on('change', '.priority_select', function (){
	// 	let $this = $(this),
	// 		value = $this.val();
	//
	// 	priority_select.find('option').attr('disabled', false);
	// 	priority_select.each(function (){
	// 		$(this).not($this).find('option[value="'+value+'"]').attr('disabled', 'disabled');
	// 	})
	// })

	/**
	 * End
	 */

	/**
	 * Ajax for Add Priority
	 */
	$(document).on('click', '.submit-priorities', function (e){
		e.preventDefault();

		let input = $(this),
			form = $('.workshop-priorities'),
			form_data = form.serialize();

		form_data = form_data+'&action=ajax_priorities';

		$.ajax({
			url: muf.ajaxurl,
			data: form_data,
			type : 'POST',
			success : function ( data ){
				console.log(data);
				$('.success_box .success_text_2').hide();
				$('.success_box .success_text_1').hide();
				$('.success_box .success_text_3').hide();
				$('.success_box .success_text_4').show();
			}
		})
		return false;
	})
	/**
	 * End
	 */
}( jQuery ) );
