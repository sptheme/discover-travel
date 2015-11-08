jQuery(document).ready(function($){

    // Send custom tour design
    $('.send-tour-design').steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex) {
            // Allways allow step back to the previous step even if the current step is not valid!
            if (currentIndex > newIndex) {
                return true;
            }
            $('.send-tour-design').validate().settings.ignore = ":disabled,:hidden";
            return $('.send-tour-design').valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
                    resizeJquerySteps();
        },
        onFinishing: function (event, currentIndex) {
            $('.send-tour-design').validate().settings.ignore = ":disabled";
            return $('.send-tour-design').valid();
        },
        onFinished: function (event, currentIndex) {
            var data = {
                action:"wpsp_send_tour_design",
                tours : $('.send-tour-design').serialize()
            };
            $.post( dt_tour_inquiry_obj.ajaxURL, data, function(response) {
                $('.send-tour-design').hide();
                $('#result').show().html(response);
            });
            return false;
        }
    }).validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            email: {
                email: true
            },
            phone: {
                number: true
            }
        },
    });    

    function resizeJquerySteps() {
        $('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");
    }

    $(window).resize(resizeJquerySteps);


    var $type_family = $('.type-family'),
        $type_group = $('.type-group'),
        $people_addon = $('.people-addon');
        
	// Tour inquiry form
    $('.tour-inquiry').magnificPopup({
        type:'inline',
        midClick: true,
        removalDelay: 500,
        mainClass: 'mfp-zoom-in', // this class is for CSS animation below
        callbacks: {
            open: function() {
                $('#result').hide();
                $('.send-tour-inquiry').show();
                $('#type-solo, #eco-class').addClass('active');
            },
            close: function() {
                $people_addon.hide();
                $('.people, .tour-class, #is-flexible-date').removeClass('active');
                $('.send-tour-inquiry')[0].reset();
            }
        }
    });

    // Show/hide people addon
    $('.people').click( function() {
		var $tour_type = $(this).attr('id');
		$('.people').removeClass('active');
    	$(this).addClass('active');
    	//console.log( $('input:radio[name=tour_type]:checked').val() );
        if ( $tour_type === 'type-family' ) {
            $people_addon.addClass('is-family');
        } else {
            $people_addon.removeClass('is-family');
        }

    	if ( $tour_type === 'type-family' || $tour_type === 'type-group' ) {
    		$people_addon.slideDown();
    	} else {
    		$people_addon.slideUp();
    	}
    });

    // Show/hide tour class
    $('.tour-class').click( function() {
        $('.tour-class').removeClass('active');
        $(this).addClass('active');
    });

    // Departure date
    $('#departure-date, #start-date').datepicker();
    $('#flexible-date').change( function() {
        $('#is-flexible-date').toggleClass('active');
    });

    // Submit tour inquiry
    $('.send-tour-inquiry').validate({
        rules: {
            departuredate: {
                required: true
            },
            firstname: {
                required: true
            },
            lastname: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                number: true
            },
            country: {
                required: true
            }
        },
        submitHandler: function (form) {
            var data = {
                action:"wpsp_send_tour_inquiry",
                tours : $('.send-tour-inquiry').serialize()
            };
            $.post( dt_tour_inquiry_obj.ajaxURL, data, function(response) {
                $('.send-tour-inquiry').hide();
                $('#result').show().html(response);
            });
            return false;
        }
    });

    // Scroll to design form
    $('.custom-tour-btn a').click( function(){
        $('html, body').animate({
            scrollTop: $("#custom-tour-design .section-title").offset().top
        }, 1000);
    });

    // custom checkbox
    $(".checkbox-item").change(function() {
        $(this).parent().toggleClass('active');
        if(this.checked) {
            console.log( $(this).val() );
        }
    });
	
});