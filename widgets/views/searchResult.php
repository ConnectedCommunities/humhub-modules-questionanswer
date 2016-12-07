<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
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
?>
<?php
/**
 * This View shows a post inside the search
 *
 * @property Post $post is the post object
 *
 * @package humhub.modules.post
 * @since 0.5
 */
?>

<li>
    <a href="<?php echo $this->createUrl('//questionanswer/question/view', array('id' => $question->id)); ?>">
        <div class="media">
            <div class="media-body">
                <strong><?php echo CHtml::encode($question->post_title); ?> </strong><br>
                <span class="content"><?php echo CHtml::encode(Helpers::truncateText($question->post_text, 150)); ?></span>
                <br />
                <?php foreach($question->tags as $tag) { ?>
                    <span class="label label-default"><?php echo $tag->tag->tag; ?></span>
                <?php } ?>
            </div>
        </div>
    </a>
</li>