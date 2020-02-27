<?php

declare(strict_types=1);

/*
 * This file is part of the Sami utility.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sami\Reflection;

use Sami\Project;

class ConstantReflection extends Reflection {
    protected $class;
    protected $modifiers;

    public function __toString() {
        return $this->class . '::' . $this->name;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass(ClassReflection $class) {
        $this->class = $class;
    }

    public function setModifiers($modifiers) {
        // if no modifiers, method is public
        if (($modifiers & self::VISIBILITY_MODIFER_MASK) === 0) {
            $modifiers |= self::MODIFIER_PUBLIC;
        }

        $this->modifiers = $modifiers;
    }

    public function isPublic() {
        return (self::MODIFIER_PUBLIC & $this->modifiers) === self::MODIFIER_PUBLIC;
    }

    public function isProtected() {
        return (self::MODIFIER_PROTECTED & $this->modifiers) === self::MODIFIER_PROTECTED;
    }

    public function isPrivate() {
        return (self::MODIFIER_PRIVATE & $this->modifiers) === self::MODIFIER_PRIVATE;
    }

    public function isStatic() {
        return false;
    }

    public function isAbstract() {
        return false;
    }

    public function isFinal() {
        return false;
    }

    public function toArray() {
        return [
            'name' => $this->name,
            'line' => $this->line,
            'short_desc' => $this->shortDesc,
            'long_desc' => $this->longDesc,
            'tags' => $this->tags,
            'modifiers' => $this->modifiers,
        ];
    }

    public static function fromArray(Project $project, $array) {
        $constant = new self($array['name'], $array['line']);
        $constant->shortDesc = $array['short_desc'];
        $constant->longDesc = $array['long_desc'];
        $constant->modifiers = $array['modifiers'] ?? [];

        return $constant;
    }
}
