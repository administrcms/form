<?php

namespace Administr\Form\Presenters;

use Administr\Form\Field\AbstractType;

interface Presenter
{
    public function render(AbstractType $field, array $error = []);
}
