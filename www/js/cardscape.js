/* cardscape.js
 * 
 * This file is part of Cardscape.
 * Web based collaborative platform for creating Collectible Card Games.
 *
 * Copyright (c) 2011 - 2013, the Cardscape team.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
$((function(cardscape, $, undefined) {

    $.extend(cardscape, {
        resetUserActivation: function() {
            if (!confirm("Are you sure you want to reset this user's password?")) {
                return false;
            }

            $.fn.yiiGridView.update('user-grid', {
                type: 'POST',
                url: $(this).attr('href'),
                success: function(data) {
                    $.fn.yiiGridView.update('user-grid');
                },
                error: function(XHR) {
                    //TODO: add proper error handling
                }
            });

            return false;
        }
    });
})(window.cardscape = window.cardscape || {}, jQuery));

/**
 * Attributes form object
 * @param {type} $
 * @param {type} undefined
 */
$((function($, undefined) {
    var multiLinesCount = 0;

    /**
     * Removes the option line where the user clicked, it will be used in click 
     * events for the remove icon when the attribute is a multi-line attribute.
     * 
     * @param {object} event
     */
    function removeLine(event) {
        $('.multivalue-line-' + $(this).data('line')).fadeOut(function() {
            $(this).remove();
        });
        multiLinesCount -= 1;
    }
    /**
     * Adds event handlers and detects initial variable values like the amount 
     * of existing multi-value lines.
     */
    function init() {
        $('.add-multiline').click(function(event) {
            //cloning the first line that should always exist, updating clone's details
            var $lineClone = $('.multivalue-line-hidden').clone();
            $lineClone.removeClass('multivalue-line-hidden')
                    .removeClass('hidden')
                    .addClass('multivalue-line-' + multiLinesCount);

            //getting child elements that need updating
            $lineClone.find('label.option')
                    .removeClass('option')
                    .attr('for', 'AttributeOption_key_' + multiLinesCount);
            $lineClone.find('input#templateOption')
                    .attr('id', 'AttributeOption_key_' + multiLinesCount)
                    .attr('name', 'AttributeOption[key][' + multiLinesCount + ']');

            $lineClone.find('label.translation')
                    .removeClass('translation')
                    .attr('for', 'AttributeOptionI18N_string_' + multiLinesCount);
            $lineClone.find('input#templateTranslation')
                    .attr('id', 'AttributeOptionI18N_string_' + multiLinesCount)
                    .attr('name', 'AttributeOptionI18N[string][' + multiLinesCount + ']');

            $lineClone.find('img')
                    .data('line', multiLinesCount)
                    .click(removeLine);

            $lineClone.hide().appendTo($('.multivalue-lines')).fadeIn();
            multiLinesCount += 1;
        });

        multiLinesCount = parseInt($('.multiline-count').text(), 10);
        $('.rm-multiline').click(removeLine);
    }

    //auto-load/execution
    init();
})(jQuery));