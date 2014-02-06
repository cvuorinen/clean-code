
// Add event listener to reveal.js slide changes
Reveal.addEventListener('slidechanged', function(event) {
    // event.previousSlide, event.currentSlide, event.indexh, event.indexv

    // Type text into slide title
    var text = $(event.currentSlide).attr('data-type-title');
    var target = $(event.currentSlide).find('.title').first();
    if (text && target && $(target).text().length == 0) {
        typeText(text, target);
    }
});

Reveal.addEventListener('fragmentshown', function(event) {
    // event.fragment = the fragment DOM element
    
    // Type text into fragment element
    var text = $(event.fragment).attr('data-type-text');
    if (text  && $(event.fragment).text().length == 0) {
        typeText(text, $(event.fragment));
    }

    // Apply class to current slide (section tag)
    var sectionClass = $(event.fragment).attr('data-section-class');
    if (sectionClass) {
        $(event.fragment).parent().addClass(sectionClass);
    }
});

// "Type" text into an html element
function typeText(text, targetElement, erase)
{
    var deferred = $.Deferred();

    if (erase) {
        setTimeout(
            function() {
                eraseTextFromElement(
                    targetElement,
                    true
                ).done(function() {
                    typeTextToElement(text, targetElement)
                    .done(function() {
                        deferred.resolve();
                    });
                });
            },
            400
        );
    }
    else {
        typeTextToElement(text, targetElement)
        .done(function() {
            deferred.resolve();
        });
    }

    return deferred.promise();
}

function typeTextToElement(text, targetElement)
{
    var deferred = $.Deferred();

    if (text.length <= 0) return;

    $(targetElement).text($(targetElement).text() + text.charAt(0));

    var remainingText = text.substring(1);

    if (remainingText.length > 0) {
        setTimeout(function(){
            typeTextToElement(remainingText, targetElement).done(deferred.resolve)
        }, randomBetween(50, 250));
    }
    else {
        deferred.resolve();
    }

    return deferred.promise();
}

function eraseTextFromElement(targetElement, first)
{
    var deferred = $.Deferred();

    var text = $(targetElement).text();

    var remainingText = text.substring(0, (text.length - 1));

    if (text.length > 0) {
        $(targetElement).text(remainingText);
    }

    var timeout = (first) ? 500 : 30;

    if (remainingText.length > 0) {
        setTimeout(function(){
            eraseTextFromElement(targetElement).done(deferred.resolve)
        }, timeout);
    }
    else {
        deferred.resolve();
    }

    return deferred.promise();
}

function randomBetween(from,to)
{
    return Math.floor(Math.random() * (to - from + 1) + from);
}
