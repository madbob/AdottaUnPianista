$(document).ready(function() {
    $('input.date').datepicker({
        format: 'DD dd MM yyyy',
        autoclose: true,
        language: 'it',
        clearBtn: true
    });

    $('body')
		.on('submit', '.async-form', function(e) {
	        e.preventDefault();

			var form = $(this);
			form.find('button[type=submit]').prop('disabled', true);
	        var datastring = form.serialize();

	        $.ajax({
	            type: $(this).attr('method'),
	            url: $(this).attr('action'),
	            data: datastring,
	            dataType: "HTML",

	            success: function(data) {
					form.closest('.panel').replaceWith(data);
	            },
	            error: function(data) {
                    var j = $.parseJSON(data.responseText);
	                alert(j.error);
                    form.find('button[type=submit]').prop('disabled', false);
	            }
	        });
	    })
        .on('submit', '.add-attendee', function(e) {
	        e.preventDefault();

			var form = $(this);
            var slot_id = form.find('input[name=slot_id]').val();
			form.find('button[type=submit]').prop('disabled', true);
	        var datastring = form.serialize();

	        $.ajax({
	            type: $(this).attr('method'),
	            url: $(this).attr('action'),
	            data: datastring,
	            dataType: "HTML",

	            success: function(data) {
					var slot = $('.panel[data-slot-id=' + slot_id + ']');
                    var table = slot.find('.attendees tbody').append(data);
	            },
	            error: function(data) {
                    var j = $.parseJSON(data.responseText);
	                alert(j.error);
                    form.find('button[type=submit]').prop('disabled', false);
	            }
	        });
	    })
		.on('change', 'select[name=location]', function() {
			var target = $(this).val();
			var info = $(this).closest('form').find('.location-info');

			/*
				L'array locations viene generato direttamente dentro al template
				event.edit
			*/
			for (var i = 0; i < locations.length; i++) {
				var l = locations[i];
				if (l.id == target) {
					info.find('label[for=name]').closest('div').find('p').text(l.name);
					info.find('label[for=address]').closest('div').find('p').text(l.address);
					info.find('label[for=capacity]').closest('div').find('p').text(l.capacity);
					info.find('label[for=phone]').closest('div').find('p').text(l.phone);
					info.find('label[for=email]').closest('div').find('p').text(l.email);
					break;
				}
			}
		})
        .on('click', '.remove-attendee', function() {
            var button = $(this);

            if (confirm('Sei sicuro di rimuovere questo partecipante?')) {
                var id = button.closest('tr').attr('data-attendee-id');
                $.ajax({
                    type: 'POST',
                    url: '/prenotazione/rimuovi-partecipante',
                    data: {
                        id: id,
                        _token: window.Laravel.csrfToken
                    },

                    success: function() {
                        button.closest('tr').remove();
                    },
    	            error: function(data) {
                        var j = $.parseJSON(data.responseText);
    	                alert(j.error);
    	            }
                });
            }
        });

    $('.cells').on('click', '.delete-booking', function(e) {
		e.preventDefault();

		if(confirm('Sei sicuro di voler cancellare questa prenotazione?')) {
			$(this).closest('form').append('<input type="hidden" name="delete-me" value="1">').submit();
		}
	});

    if ($('.many-rows').length != 0) {
        function manyRowsAddDeleteButtons(node) {
            if (node.find('.delete-many-rows').length == 0) {
                var fields = node.find('.fields');
                if (fields.length > 1) {
                    fields.each(function() {
                        var button = '<button class="delete-many-rows"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                        $(this).find('td:last').append(button);
                    });
                }
            }
        }

        $('body').on('click', '.many-rows .delete-many-rows', function(e) {
            e.preventDefault();
            var container = $(this).parents('.many-rows');
            $(this).parents('.fields').remove();

            var rows = container.find('.fields');
            if (rows.length <= 1)
                container.find('.delete-many-rows').remove();

            var available = parseInt(container.closest('.panel-footer').find('.still-available').text());
            if (available - rows.length > 0)
                container.find('.add-many-rows').prop('disabled', false);

            return false;
        });

        $('body').on('click', '.many-rows .add-many-rows', function(e) {
            e.preventDefault();
            var container = $(this).parents('.many-rows');
            var rows = container.find('.fields');

            var row = rows.first().clone();
            row.find('input').val('');
            container.find('.add-many-rows').closest('tr').before(row);
            manyRowsAddDeleteButtons(container);

            var available = parseInt($(this).closest('.panel-footer').find('.still-available').text());
            if (available - rows.length - 1 <= 0)
                $(this).prop('disabled', true);

            return false;
        });

        $('.many-rows').each(function() {
            manyRowsAddDeleteButtons($(this));
        });
    }
});
