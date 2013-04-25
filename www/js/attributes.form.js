/* attributes.form.js
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
$((function($, undefined) {
    var multiLinesCount = 0;

    /**
     * Adds event handlers and detects initial variable values like the amount 
     * of existing multi-value lines.
     */
    function init() {
        $('.add-multiline').click(function(event) {
            //cloning the first line that should always exist, updating clone's details
            var $lineClone = $('.multivalue-line-0').clone();
            $lineClone.removeClass('multivalue-line-0')
                    .addClass('multivalue-line-' + multiLinesCount);

            //getting child elements that need updating
            $lineClone.find('label[for=AttributeOption_key_0]').attr('for', 'AttributeOption_key_' + multiLinesCount);
            $lineClone.find('#AttributeOption_key_0').attr('id', 'AttributeOption_key_' + multiLinesCount)
                    .attr('name', 'AttributeOption[key][' + multiLinesCount + ']');
            $lineClone.find('label[for=AttributeOptionI18N_string_0]').attr('for', 'AttributeOptionI18N_string_' + multiLinesCount)
                    .attr('for', 'AttributeOptionI18N[string][' + multiLinesCount + ']');
            $lineClone.find('#AttributeOptionI18N_string_0').attr('id', 'AttributeOptionI18N_string_' + multiLinesCount);
            $lineClone.appendTo($('.multivalue-lines'));
            multiLinesCount += 1;
        });

        multiLinesCount = parseInt($('.multiline-count').text(), 10);
    }

    //auto-load/execution
    init();
})(jQuery));
