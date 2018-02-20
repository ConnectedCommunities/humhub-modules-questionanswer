<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace humhub\modules\questionanswer\models;

use humhub\modules\questionanswer\widgets\HashtagLinkWidget;

class Hashtag
{

//    const HASHTAG_PATTERN = '/\#\[(.*?)\]/'; // #[Hash Tag Here] format
    const HASHTAG_PATTERN = '/#(\w*[0-9a-zA-Z]+\w*[0-9a-zA-Z])/'; // #hashtag format

    const ZERO_SPACE_CHAR = '&#x200b;';
    const ZERO_SPACE_CHAR_ALT = '::!!ZERO_SPACE_CHAR!!::';

    /**
     * Strip the hashtag pattern from a string
     *
     * @return string
     */
    public static function strip($text)
    {
        return substr($text, 1); // #hashtag format
        // return substr($text, 2, -1); // #[hash tag here] format
    }

    /**
     * Convert a hashtag into a url friendly string
     *
     * @param $text
     * @return string
     */
    public static function slug($text)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', self::strip($text))));
    }

    /**
     * Replace hashtags from text to link tag
     *
     * @param string $text Contains the complete message
     * @return mixed
     */
    public static function translateHashtags($text)
    {
        return preg_replace_callback_array([

            // Replace Zero Width Space character
            '/' . Hashtag::ZERO_SPACE_CHAR .'/i' => function() {
                return Hashtag::ZERO_SPACE_CHAR_ALT;
            },

            // Replace hashtag text with hashtag link
            Hashtag::HASHTAG_PATTERN => function($hit) {
                return HashtagLinkWidget::widget(['hashtag' => $hit[0]]);
            },

            // Replace alternative Zero Width Space character
            '/' . Hashtag::ZERO_SPACE_CHAR_ALT . '/i' => function() {
                return Hashtag::ZERO_SPACE_CHAR;
            }

        ], $text);
    }

}
