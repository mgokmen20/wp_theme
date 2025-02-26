<?php
comment_form(array(
    'title_reply' => 'Bitte äußern Sie sich zu dieser Angelegenheit',
    'class_form' => 'comment-form',
    'fields' => array(
        'author' => '<input class="form-control mb-3" id="author" name="author" type="text" placeholder="Ihr Name" value="' . esc_attr($commenter['comment_author']) . '" required />',
        'email'  => '<input class="form-control mb-3" id="email" name="email" type="email" placeholder="Ihre E-Mail-Adresse" value="' . esc_attr($commenter['comment_author_email']) . '" required />',
    ),
    'comment_field' => '<textarea class="form-control" id="comment" name="comment" rows="5" placeholder="Schreiben Sie Ihren Kommentar hier..." required></textarea>',
    'label_submit' => 'Kommentar absenden',
    'class_submit' => 'btn btn-primary',
));
?>
