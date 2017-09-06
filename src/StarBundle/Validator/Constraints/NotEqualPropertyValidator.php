<?php

namespace StarBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotEqualPropertyValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        dump($value);die;
    }
}