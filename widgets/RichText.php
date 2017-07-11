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

namespace humhub\modules\questionanswer\widgets;

use humhub\modules\questionanswer\models\Hashtag;

/**
 * Tap into the RichText widget and parse hashtags
 *
 * Class RichText
 * @package humhub\modules\questionanswer\widgets
 */
class RichText extends \humhub\widgets\RichText
{

    /**
     * Replace hashtags from text to link tag
     */
    public function run()
    {
        return Hashtag::translateHashtags(parent::run());
    }

}

?>
