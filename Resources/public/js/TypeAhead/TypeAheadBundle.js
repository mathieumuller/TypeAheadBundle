var TypeAheadBundle = {
    substringMatcher: function(dataset) {
        return function findMatches(q, cb) {
            var matches, substrRegex;
            // an array that will be populated with substring matches
            matches = [];
            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');
            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(dataset, function(i, data) {
                if (substrRegex.test(data.search_value)) {
                    // the typeahead jQuery plugin expects suggestions to a
                    // JavaScript object, refer to typeahead docs for more info
                    matches.push({ displayed: data.displayed_value, value: data.selected_value });
                }
            });

            cb(matches);
        };
    },

    getEntityByDisplay: function(dataset, display_value, value_input) {
        $.each(dataset, function(i, data) {
            if (data.displayed_value == display_value) {

                value_input.val(data.selected_value);
                return;
            }

            return;
        });
    },

    typeAheadProcessor :function(dataset, value_input, onSelectFunction) {
        var display_input = $(value_input).parent().find(".typeahead");

        display_input.on("keyup", function(e){
            if (! $(value_input).val()) {
                display_input.addClass("typeAheadError");
            }
        });

        $(display_input).on("blur", function(e){
            TypeAheadBundle.getEntityByDisplay(dataset, display_input.val(), $(value_input));
            if ($(value_input).val().length) {
                display_input.removeClass("typeAheadError");
                display_input.addClass("typeAheadOk");

                if(!$(display_input).val().length) {
                    display_input.removeClass("typeAheadError");
                }
            }
        });

        $(".tt-eraser").on("click", function(e){
            e.preventDefault();
            $(this).parent().find("input[type=text]").val("").removeClass("typeAheadError").removeClass("typeAheadOk");
            $(this).parent().find("input[type=hidden]").val("");
            $(value_input).trigger("typeahead_change");
        });

        $(".typeahead").on("change", function() {
            if (!$(this).val().length) {
                $(".typeahead").removeClass("typeAheadError");
            }
        });

        $(display_input).typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                displayKey: 'displayed',
                source:     this.substringMatcher(dataset)
            }
        ).bind("typeahead:selected", function(obj, datum, name) {
            //return id in an input hidden
            $(value_input).val(datum.value);
            $(value_input).trigger("typeahead_change");
            display_input.removeClass("typeAheadError");
            display_input.addClass("typeAheadOk");

        }).bind("typeahead:open", function(){
            // reinitialize the input hidden
            $(value_input).val("");
            $(display_input).removeClass("typeAheadOk");
        });
        
        $(value_input).on("typeahead_change", function(){
            onSelectFunction();
        });
    }
};

