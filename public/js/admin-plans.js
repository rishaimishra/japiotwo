jQuery(document).ready(function($){
	//hide the subtle gradient layer (.pricing-list > li::after) when pricing table has been scrolled to the end (mobile version only)
	checkScrolling($('.pricing-body'));
	$(window).on('resize', function(){
		window.requestAnimationFrame(function(){checkScrolling($('.pricing-body'))});
	});
	$('.pricing-body').on('scroll', function(){ 
		var selected = $(this);
		window.requestAnimationFrame(function(){checkScrolling(selected)});
	});

	function checkScrolling(tables){
		tables.each(function(){
			var table= $(this),
				totalTableWidth = parseInt(table.children('.pricing-features').width()),
		 		tableViewport = parseInt(table.width());
			if( table.scrollLeft() >= totalTableWidth - tableViewport -1 ) {
				table.parent('li').addClass('is-ended');
			} else {
				table.parent('li').removeClass('is-ended');
			}
		});
	}

	//switch from monthly to annual pricing tables
	bouncy_filter($('.pricing-container'));

	function bouncy_filter(container) {
		container.each(function(){
			var pricing_table = $(this);
			var filter_list_container = pricing_table.children('.pricing-switcher'),
				filter_radios = filter_list_container.find('input[type="radio"]'),
				pricing_table_wrapper = pricing_table.find('.pricing-wrapper');

			//store pricing table items
			var table_elements = {};
			filter_radios.each(function(){
				var filter_type = $(this).val();
				table_elements[filter_type] = pricing_table_wrapper.find('li[data-type="'+filter_type+'"]');
			});

			//detect input change event
			filter_radios.on('change', function(event){
				event.preventDefault();
				//detect which radio input item was checked
				var selected_filter = $(event.target).val();

				//give higher z-index to the pricing table items selected by the radio input
				show_selected_items(table_elements[selected_filter]);

				//rotate each pricing-wrapper 
				//at the end of the animation hide the not-selected pricing tables and rotate back the .pricing-wrapper
				
				if( !Modernizr.cssanimations ) {
					hide_not_selected_items(table_elements, selected_filter);
					pricing_table_wrapper.removeClass('is-switched');
				} else {
					pricing_table_wrapper.addClass('is-switched').eq(0).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {		
						hide_not_selected_items(table_elements, selected_filter);
						pricing_table_wrapper.removeClass('is-switched');
						//change rotation direction if .pricing-list has the .bounce-invert class
						if(pricing_table.find('.pricing-list').hasClass('bounce-invert')) pricing_table_wrapper.toggleClass('reverse-animation');
					});
				}
			});
		});
	}
	function show_selected_items(selected_elements) {
		selected_elements.addClass('is-selected');
	}

	function hide_not_selected_items(table_containers, filter) {
		$.each(table_containers, function(key, value){
	  		if ( key != filter ) {	
				$(this).removeClass('is-visible is-selected').addClass('is-hidden');

			} else {
				$(this).addClass('is-visible').removeClass('is-hidden is-selected');
			}
		});
	}
});


$(document).ready(function() { 

    $('.MaincustomisedCheckbox1').click(function(){
      if($(this).prop("checked") == true){
        alert();
          var monthlyVal = parseInt($('#CustomPriceAddonWithMonthly1').val());
          $('#MainValueMonthly1').text(monthlyVal);
      }
      else if($(this).prop("checked") == false){
        var monthlyDefaultVal = parseInt($('#CustomPriceAddonWithMonthly1').data('value'));
        $('#MainValueMonthly1').text(monthlyDefaultVal);
      }
    });
    $('.MaincustomisedCheckbox2').click(function(){
      if($(this).prop("checked") == true){
          var monthlyVal2 = parseInt($('#CustomPriceAddonWithMonthly2').val());   
          $('#MainValueMonthly1').text(monthlyVal2);
      }
      else if($(this).prop("checked") == false){
        var monthlyDefaultVal2 = parseInt($('#CustomPriceAddonWithMonthly2').data('value'));
        $('#MainValueMonthly1').text(monthlyDefaultVal2);
      }
    });
    $('.MaincustomisedCheckbox4').click(function(){
      if($(this).prop("checked") == true){
          var monthlyVal4 = parseInt($('#CustomPriceAddonWithMonthly4').val());
          $('#MainValueMonthly4').text(monthlyVal4);
      }
      else if($(this).prop("checked") == false){
        var monthlyDefaultVal4 = parseInt($('#CustomPriceAddonWithMonthly4').data('value'));
        $('#MainValueMonthly4').text(monthlyDefaultVal4);
      }
    });
     $('.MaincustomisedCheckbox5').click(function(){
      if($(this).prop("checked") == true){
          var monthlyVal5 = parseInt($('#CustomPriceAddonWithMonthly5').val());
          $('#MainValueMonthly4').text(monthlyVal5);
      }
      else if($(this).prop("checked") == false){
        var monthlyDefaultVal5 = parseInt($('#CustomPriceAddonWithMonthly5').data('value'));
        $('#MainValueMonthly4').text(monthlyDefaultVal5);
      }
    });
     $('.MaincustomisedCheckbox6').click(function(){
      if($(this).prop("checked") == true){
         var monthlyVal6 = parseInt($('#CustomPriceAddonWithMonthly6').val());
          $('#MainValueMonthly4').text(monthlyVal6);
      }
      else if($(this).prop("checked") == false){
        var monthlyDefaultVal6 = parseInt($('#CustomPriceAddonWithMonthly6').data('value'));
        $('#MainValueMonthly4').text(monthlyDefaultVal6);
      }
    });
    $('.MaincustomisedCheckbox8').click(function(){
      if($(this).prop("checked") == true){
          var monthlyVal8 = parseInt($('#CustomPriceAddonWithMonthly8').val());
        
          $('#MainValueMonthly8').text(monthlyVal8);
      }
      else if($(this).prop("checked") == false){
        var monthlyDefaultVal8 = parseInt($('#CustomPriceAddonWithMonthly8').data('value'));
        $('#MainValueMonthly8').text(monthlyDefaultVal8);
      }
    });
    $('.MaincustomisedCheckbox9').click(function(){
      if($(this).prop("checked") == true){
          var monthlyVal9 = parseInt($('#CustomPriceAddonWithMonthly9').val());
          $('#MainValueMonthly8').text(monthlyVal9);
      }
      else if($(this).prop("checked") == false){
        var monthlyDefaultVal9 = parseInt($('#CustomPriceAddonWithMonthly9').data('value'));
        $('#MainValueMonthly8').text(monthlyDefaultVal9);
      }
    });
    $('.MaincustomisedCheckbox10').click(function(){
      if($(this).prop("checked") == true){
          var monthlyVal10 = parseInt($('#CustomPriceAddonWithMonthly10').val());
          $('#MainValueMonthly8').text(monthlyVal10);
      }
      else if($(this).prop("checked") == false){
        var monthlyDefaultVal10 = parseInt($('#CustomPriceAddonWithMonthly10').data('value'));
        $('#MainValueMonthly8').text(monthlyDefaultVal10);
      }
    });



     $('.MaincustomisedCheckboxYear1').click(function(){
      if($(this).prop("checked") == true){
          var yearlyValue = parseInt($('#CustomPriceAddonWithYearly1').val());
          $('#MainValueYear3').text(yearlyValue);
      }
      else if($(this).prop("checked") == false){
        var yearlyDefaultValue = parseInt($('#CustomPriceAddonWithYearly1').data('value'));
        $('#MainValueYear3').text(yearlyDefaultValue);
      }
    });
    $('.MaincustomisedCheckboxYear2').click(function(){
      if($(this).prop("checked") == true){
          var yearlyValue2 = parseInt($('#CustomPriceAddonWithYearly2').val());
          $('#MainValueYear3').text(yearlyValue2);
      }
      else if($(this).prop("checked") == false){
          var yearlyDefaultValue2 = parseInt($('#CustomPriceAddonWithYearly2').data('value'));
          $('#MainValueYear3').text(yearlyDefaultValue2);
      }
    });
    $('.MaincustomisedCheckboxYear4').click(function(){
      if($(this).prop("checked") == true){
         var yearlyValue4 = parseInt($('#CustomPriceAddonWithYearly4').val());
          $('#MainValueYear7').text(yearlyValue4);
      }
      else if($(this).prop("checked") == false){
        var yearlyDefaultValue4 = parseInt($('#CustomPriceAddonWithYearly4').data('value'));
        $('#MainValueYear7').text(yearlyDefaultValue4);
      }
    });
    $('.MaincustomisedCheckboxYear5').click(function(){
      if($(this).prop("checked") == true){
          var yearlyValue5 = parseInt($('#CustomPriceAddonWithYearly5').val());
          $('#MainValueYear7').text(yearlyValue5);
      }
      else if($(this).prop("checked") == false){
          var yearlyDefaultValue5 = parseInt($('#CustomPriceAddonWithYearly5').data('value'));
          $('#MainValueYear7').text(yearlyDefaultValue5);
      }
    });
     $('.MaincustomisedCheckboxYear6').click(function(){
      if($(this).prop("checked") == true){
          var yearlyValue6 = parseInt($('#CustomPriceAddonWithYearly6').val());
          $('#MainValueYear7').text(yearlyValue6);
      }
      else if($(this).prop("checked") == false){
        var yearlyDefaultValue6 = parseInt($('#CustomPriceAddonWithYearly6').data('value'));
        $('#MainValueYear7').text(yearlyDefaultValue6);
      }
    });
    
     $('.MaincustomisedCheckboxYear8').click(function(){
      if($(this).prop("checked") == true){
          var yearlyValue8 = parseInt($('#CustomPriceAddonWithYearly8').val());
          $('#MainValueYear11').text(yearlyValue8);
      }
      else if($(this).prop("checked") == false){
        var yearlyDefaultValue8 = parseInt($('#CustomPriceAddonWithYearly8').data('value'));
        $('#MainValueYear11').text(yearlyDefaultValue8);
      }
    });
     $('.MaincustomisedCheckboxYear9').click(function(){
      if($(this).prop("checked") == true){
        var yearlyValue9 = parseInt($('#CustomPriceAddonWithYearly9').val());
        $('#MainValueYear11').text(yearlyValue9);
      }
      else if($(this).prop("checked") == false){
        var yearlyDefaultValue9 = parseInt($('#CustomPriceAddonWithYearly9').data('value'));
        $('#MainValueYear11').text(yearlyDefaultValue9);
      }
    });
     $('.MaincustomisedCheckboxYear10').click(function(){
      if($(this).prop("checked") == true){
          var yearlyValue10 = parseInt($('#CustomPriceAddonWithYearly10').val());
          $('#MainValueYear11').text(yearlyValue10);
      }
      else if($(this).prop("checked") == false){
        var yearlyDefaultValue10 = parseInt($('#CustomPriceAddonWithYearly10').data('value'));
        $('#MainValueYear11').text(yearlyDefaultValue10);
      }
    });


  });
