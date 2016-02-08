<?php

namespace Administr\Form;

interface ValidatesWhenSubmitted
{
    /**
     * Validate a form after submission.
     *
     * @return void
     */
    public function validate();
}
