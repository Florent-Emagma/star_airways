<?php
namespace StarBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class NotEqualProperty extends Constraint
{
    public $message = 'The string "{{ string }}" contains an illegal character: it can only contain letters or numbers.';
    public $compareProperty = '';

    public function validatedBy()
    {

    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}