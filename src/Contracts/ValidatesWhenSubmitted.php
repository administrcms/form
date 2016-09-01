<?php

namespace Administr\Form\Contracts;

interface ValidatesWhenSubmitted
{
    /**
     * Validate a form after submission.
     *
     * @return void
     */
    public function validate();
}
